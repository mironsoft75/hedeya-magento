<?php
declare(strict_types=1);

/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Model\Publisher;

use Magento\AsynchronousOperations\Api\Data\OperationInterfaceFactory;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\Bulk\BulkManagementInterface;
use Magento\Framework\DataObject\IdentityGeneratorInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Vigor\ERPIntegrator\Api\ERPCatalogBridgeInterface;
use Vigor\ERPIntegrator\Helper\SyncDate;

/**
 * Class CatalogPublisher
 * @package Vigor\ERPIntegrator\Model\Handler
 */
class CatalogPublisher extends AbstractPublisher
{
    protected const TOPIC_CATALOG_UPDATE_PRODUCTS = 'erp.catalog.update-products';
    protected const TOPIC_CATALOG_UPDATE_PRODUCTS_INVENTORY = 'erp.catalog.update-products-inventory';

    /**
     * @var ERPCatalogBridgeInterface
     */
    protected $catalogBridge;
    protected $syncDateHelper;

    public function __construct(BulkManagementInterface $bulkManagement, OperationInterfaceFactory $operationFactory, IdentityGeneratorInterface $identityService, UserContextInterface $userContextInterface, SerializerInterface $serializer, \Magento\Framework\EntityManager\EntityManager $entityManager, ERPCatalogBridgeInterface $catalogBridge, SyncDate $syncDateHelper)
    {
        parent::__construct($bulkManagement, $operationFactory, $identityService, $userContextInterface, $serializer, $entityManager);
        $this->catalogBridge = $catalogBridge;
        $this->syncDateHelper = $syncDateHelper;
    }


    public function addProductsToQueue(\DateTime $startDate)
    {
        $today        = new \DateTime();

        while (true) {
            $endDate = clone $startDate;
            $endDate->modify('+1 days');

            if ($startDate > $today) {
                break;
            }

            $catalogData = $this->catalogBridge->getModifiedProducts($startDate, $endDate);

            if (count($catalogData['products'])) {
                $this->addToQueue($catalogData['products'], self::TOPIC_CATALOG_UPDATE_PRODUCTS, 'ERP Products update - '. $startDate->format('Y-m-d') . ' - ' . $endDate->format('Y-m-d'));
            }
            if (count($catalogData['source_items'])) {
                $this->addToQueue($catalogData['source_items'], self::TOPIC_CATALOG_UPDATE_PRODUCTS_INVENTORY, 'ERP Products stock update - '. $startDate->format('Y-m-d') . ' - ' . $endDate->format('Y-m-d'));
            }
            $this->syncDateHelper->writeSyncData([
                $startDate->format('Y-m-d')
            ]);

            $startDate = clone $endDate;
        }
    }
}
