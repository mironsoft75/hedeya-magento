<?php

/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Controller\Adminhtml\Products;

use Magento\Backend\App\Action;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\InventoryApi\Api\Data\SourceItemInterface;
use Magento\Ui\Component\MassAction\Filter;
use Vigor\ERPIntegrator\Api\Data\ERPProductInterface;
use Vigor\ERPIntegrator\Api\ERPCatalogBridgeInterface;
use Vigor\ERPIntegrator\Model\Handler\CatalogInventoryHandler;
use Vigor\ERPIntegrator\Model\Handler\CatalogProductsHandler;

class Sync extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var ERPCatalogBridgeInterface
     */
    private $catalogBridge;
    /**
     * @var CatalogProductsHandler
     */
    private $productsHandler;
    /**
     * @var CatalogInventoryHandler
     */
    private $inventoryHandler;

    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ProductRepositoryInterface $productRepository,
        ERPCatalogBridgeInterface $catalogBridge,
        CatalogProductsHandler $productsHandler,
        CatalogInventoryHandler $inventoryHandler
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
        $this->catalogBridge = $catalogBridge;
        $this->productsHandler = $productsHandler;
        $this->inventoryHandler = $inventoryHandler;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $productsSynced = 0;
        $productsFailedToSyncSkus = [];

        /** @var \Magento\Catalog\Model\Product $product */
        foreach ($collection->getItems() as $product) {
            try {
                $erpProductData = $this->catalogBridge->getItemInfoByAlu($product->getSku());

                if (!$erpProductData) {
                    throw new LocalizedException(__('Product not found on ERP'));
                }

                $this->productsHandler->handle([
                    ProductInterface::SKU => $product->getSku(),
                    ProductInterface::PRICE => (string)$erpProductData->INVENTORY['Price'],
                    ERPProductInterface::ERP_ID_ATTRIBUTE => (string)$erpProductData->INVENTORY['Item_sid']
                ]);

                $qty = (int)$erpProductData->INVENTORY['RPCompQTY'];

                $this->inventoryHandler->handle([
                    [
                        SourceItemInterface::SKU => $product->getSku(),
                        SourceItemInterface::SOURCE_CODE => 'default',
                        SourceItemInterface::QUANTITY => $qty,
                        SourceItemInterface::STATUS => $qty > 0 ? SourceItemInterface::STATUS_IN_STOCK : SourceItemInterface::STATUS_OUT_OF_STOCK,
                    ]
                ]);

                $productsSynced++;
            } catch (\Exception $e) {
                $productsFailedToSyncSkus[] = $product->getSku();
            }
        }

        if ($productsSynced) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been synchronized.', $productsSynced)
            );
        }

        if (!empty($productsFailedToSyncSkus)) {
            $this->messageManager->addErrorMessage(
                __('A total of %1 record(s) not found by SKU on ERP', count($productsFailedToSyncSkus))
            );
            $this->messageManager->addErrorMessage(
                __('Products not synced [%1]', implode(', ', $productsFailedToSyncSkus))
            );
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('catalog/product/index');
    }
}