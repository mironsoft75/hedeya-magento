<?php
declare(strict_types=1);
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Model\Handler;

use Magento\AsynchronousOperations\Model\OperationManagement;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\InventoryApi\Api\SourceRepositoryInterface;
use Magento\InventoryCatalogAdminUi\Observer\SourceItemsProcessor;
use Vigor\ERPIntegrator\Api\Data\ERPProductInterface;

class CatalogProductsHandler extends AbstractHandler
{
    protected $productRepository;
    protected $sourceItemsProcessor;
    protected $sourceRepository;

    public function __construct(\Psr\Log\LoggerInterface $logger, OperationManagement $operationManagement, SerializerInterface $serializer, ProductRepositoryInterface $productRepository, SourceItemsProcessor $sourceItemsProcessor, SourceRepositoryInterface $sourceRepository)
    {
        parent::__construct($logger, $operationManagement, $serializer);
        $this->productRepository = $productRepository;
        $this->sourceItemsProcessor = $sourceItemsProcessor;
        $this->sourceRepository = $sourceRepository;
    }


    public function handle(array $data)
    {
        if (!isset($data[ProductInterface::SKU]) || empty(trim($data[ProductInterface::SKU]))) {
            return;
        }
        $product = null;

        try {
            $product = $this->productRepository->get($data[ProductInterface::SKU]);
        } catch (NoSuchEntityException $e) {
        }

        if ($product !== null && $product->getId()) {
            $product->addData($data);
            $product->setCustomAttribute(ERPProductInterface::ERP_ID_ATTRIBUTE, $data[ERPProductInterface::ERP_ID_ATTRIBUTE]);
            $this->productRepository->save($product);
        }
    }
}
