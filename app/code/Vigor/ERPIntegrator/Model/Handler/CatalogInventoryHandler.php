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
use Magento\InventoryApi\Api\Data\SourceInterface;
use Magento\InventoryApi\Api\Data\SourceItemInterface;
use Magento\InventoryApi\Api\SourceRepositoryInterface;
use Magento\InventoryCatalogAdminUi\Observer\SourceItemsProcessor;

class CatalogInventoryHandler extends AbstractHandler
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


    public function handle(array $sourceItems)
    {
        try {
            $product = $this->productRepository->get($sourceItems[0][SourceItemInterface::SKU]);
            for ($i = 0, $iMax = count($sourceItems); $i < $iMax; $i++) {
                try {
                    $this->sourceRepository->get($sourceItems[$i][SourceInterface::SOURCE_CODE]);
                } catch (\Exception $e) {
                    unset($sourceItems[$i]);
                }
            }
            $this->sourceItemsProcessor->process($product->getSku(), $sourceItems);
        } catch (NoSuchEntityException $e) {
            return;
        }
    }
}
