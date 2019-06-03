<?php
declare(strict_types=1);
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Model\Publisher;

use Magento\AsynchronousOperations\Api\Data\OperationInterface;
use Magento\AsynchronousOperations\Api\Data\OperationInterfaceFactory;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\Bulk\BulkManagementInterface;
use Magento\Framework\DataObject\IdentityGeneratorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\SerializerInterface;

abstract class AbstractPublisher
{
    /**
     * @var BulkManagementInterface
     */
    private $bulkManagement;

    /**
     * @var OperationInterfaceFactory
     */
    private $operationFactory;

    /**
     * @var IdentityGeneratorInterface
     */
    private $identityService;

    /**
     * @var UserContextInterface
     */
    private $userContext;

    /**
     * @var SerializerInterface
     */
    private $serializer;
    private $entityManager;

    public function __construct(
        BulkManagementInterface $bulkManagement,
        OperationInterfaceFactory $operationFactory,
        IdentityGeneratorInterface $identityService,
        UserContextInterface $userContextInterface,
        SerializerInterface $serializer,
        \Magento\Framework\EntityManager\EntityManager $entityManager
    )
    {
        $this->userContext = $userContextInterface;
        $this->bulkManagement = $bulkManagement;
        $this->operationFactory = $operationFactory;
        $this->entityManager = $entityManager;
        $this->identityService = $identityService;
        $this->serializer = $serializer;
    }

    protected function addToQueue(array $items, string $topicName, string $bulkDescription = ''): void
    {
        $operationCount = count($items);

        if ($operationCount > 0) {
            $bulkUuid = $this->identityService->generateId();
            $userId = $this->userContext->getUserId();

            if (!$this->bulkManagement->scheduleBulk($bulkUuid, [], $bulkDescription, $userId)) {
                throw new LocalizedException(
                    __('Something went wrong while scheduling ERP bulk operation.')
                );
            }

            $operations = [];
            foreach ($items as $item) {
                $serializedData = $item;

                if (is_object($item)) {
                    $serializedData = $this->serializer->serialize($item->getData());
                } elseif (is_array($item)) {
                    $unserializedData = [];
                    foreach ($item as $element) {
                        $unserializedData[] = $element->getData();
                    }
                    $serializedData = $this->serializer->serialize($unserializedData);
                }

                $data = [
                    'data' => [
                        'bulk_uuid' => $bulkUuid,
                        'topic_name' => $topicName,
                        'serialized_data' => $serializedData,
                        'status' => OperationInterface::STATUS_TYPE_OPEN,
                    ]
                ];

                /** @var OperationInterface $operation */
                $operation = $this->operationFactory->create($data);
                $operation = $this->entityManager->save($operation);
                $operations[] = $operation;
            }

            $result = $this->bulkManagement->scheduleBulk($bulkUuid, $operations, $bulkDescription, 1);
            if (!$result) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while publishing the ERP items.')
                );
            }
        }
    }
}
