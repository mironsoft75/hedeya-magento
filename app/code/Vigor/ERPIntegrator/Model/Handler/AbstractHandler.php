<?php
declare(strict_types=1);
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Model\Handler;

use Magento\AsynchronousOperations\Api\Data\OperationInterface;
use Magento\AsynchronousOperations\Model\OperationManagement;
use Magento\Framework\DB\Adapter\ConnectionException;
use Magento\Framework\DB\Adapter\DeadlockException;
use Magento\Framework\DB\Adapter\LockWaitException;
use Magento\Framework\Serialize\SerializerInterface;
use Vigor\ERPIntegrator\Api\ERPHandlerInterface;

abstract class AbstractHandler implements ERPHandlerInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    protected $operationManagement;
    protected $serializer;

    /**
     * Consumer constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @param OperationManagement $operationManagement
     * @param SerializerInterface $serializer
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        OperationManagement $operationManagement,
        SerializerInterface $serializer
    )
    {
        $this->logger = $logger;
        $this->operationManagement = $operationManagement;
        $this->serializer = $serializer;
    }

    /**
     * Processing operation for update price
     *
     * @param \Magento\AsynchronousOperations\Api\Data\OperationInterface $operation
     * @return void
     */
    public function process(\Magento\AsynchronousOperations\Api\Data\OperationInterface $operation)
    {
        $status = OperationInterface::STATUS_TYPE_COMPLETE;
        $errorCode = null;
        $message = null;
        $serializedData = $operation->getSerializedData();
        $unserializedData = $this->serializer->unserialize($serializedData);
        $resultData = null;
        try {
            $resultData = $this->handle($unserializedData);
            if ($resultData !== null) {
                $resultData = $this->serializer->serialize($resultData);
            }
        } catch (\Zend_Db_Adapter_Exception  $e) {
            $this->logger->critical($e->getMessage());
            if (
                $e instanceof LockWaitException
                || $e instanceof DeadlockException
                || $e instanceof ConnectionException
            ) {
                $status = OperationInterface::STATUS_TYPE_RETRIABLY_FAILED;
                $errorCode = $e->getCode();
                $message = __($e->getMessage());
            } else {
                $status = OperationInterface::STATUS_TYPE_NOT_RETRIABLY_FAILED;
                $errorCode = $e->getCode();
                $message = __('Sorry, something went wrong during product update. Please see log for details.');
            }

        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->logger->error($e->getMessage());
            $status = OperationInterface::STATUS_TYPE_NOT_RETRIABLY_FAILED;
            $errorCode = $e->getCode();

            $message = $e->getMessage();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->logger->critical($e->getMessage());
            $status = OperationInterface::STATUS_TYPE_NOT_RETRIABLY_FAILED;
            $errorCode = $e->getCode();
            $message = $e->getMessage();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            $status = OperationInterface::STATUS_TYPE_NOT_RETRIABLY_FAILED;
            $errorCode = $e->getCode();
            $message = __('Sorry, something went wrong during ERP update. Please see log for details.');
        }

        //update operation status based on result performing operation(it was successfully executed or exception occurs
        $this->operationManagement->changeOperationStatus(
            $operation->getId(),
            $status,
            $errorCode,
            $message,
            $serializedData,
            $resultData
        );
    }
}
