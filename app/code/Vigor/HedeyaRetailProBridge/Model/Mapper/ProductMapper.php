<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\HedeyaRetailProBridge\Model\Mapper;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\InventoryApi\Api\Data\SourceItemInterface;
use Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory;
use Vigor\ERPIntegrator\Api\Data\ERPProductInterface;
use Vigor\HedeyaRetailProBridge\Api\MapperInterface;

class ProductMapper implements MapperInterface
{
    protected $productFactory;
    protected $productRepository;
    protected $searchCriteriaBuilder;
    protected $sourceItemsFactory;

    public function __construct(
        ProductFactory $productFactory,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SourceItemInterfaceFactory $sourceItemsFactory
    )
    {
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sourceItemsFactory = $sourceItemsFactory;
    }

    public function map($items)
    {
        $mappedItems = [
            'products' => [],
            'source_items' => []
        ];

        if (isset($items) && count($items)) {
            foreach ($items as $item) {
                $product = $this->productFactory->create();
                $existingProduct = null;
                try {
                    $existingProduct = $this->productRepository->get((string)$item->ItemALU);
                } catch (NoSuchEntityException $e) {
                }

                if ($existingProduct === null) {
                    try {
                        $existingProduct = $this->productRepository->get((string)$item->ItemUPC);
                    } catch (NoSuchEntityException $e) {
                    }
                }

                if ($existingProduct === null && strlen((string)$item->ItemUPC) < 13) {
                    $upc = str_pad((string)$item->ItemUPC, 13, '0', STR_PAD_LEFT);
                    try {
                        $existingProduct = $this->productRepository->get($upc);
                    } catch (NoSuchEntityException $e) {
                    }
                }

                if ($existingProduct === null) {
                    $criteria = $this->searchCriteriaBuilder->addFilter(ERPProductInterface::ERP_ID_ATTRIBUTE, (string)$item->ItemSID)->create();
                    $result = $this->productRepository->getList($criteria);
                    if ($result->getTotalCount()) {
                        $existingProduct = $result->getItems();
                        $existingProduct = $existingProduct[0];
                    }
                }

                if ($existingProduct === null) {
                    continue;
                }

                $product->setSku($existingProduct->getSku());

                $price = trim((string)$item->ItemPrice);
                if (!empty($price)) {
                    $product->setPrice($price);
                }

                if (!empty((string)$item->ItemSID)) {
                    $product->setCustomAttribute(ERPProductInterface::ERP_ID_ATTRIBUTE, (string)$item->ItemSID);
                    $product->setData(ERPProductInterface::ERP_ID_ATTRIBUTE, (string)$item->ItemSID);
                }

                $qty = (int)trim($item->ItemRPCOMPQTY);

                $sourceItems = [];
                $sourceItem = $this->sourceItemsFactory->create();
                $sourceItem->setSourceCode('default');
                $sourceItem->setSku($product->getSku());
                $sourceItem->setQuantity($qty);
                $sourceItem->setStatus($qty > 0 ? SourceItemInterface::STATUS_IN_STOCK : SourceItemInterface::STATUS_OUT_OF_STOCK);
                $sourceItems[] = $sourceItem;

                $mappedItems['source_items'][] = $sourceItems;
                $mappedItems['products'][] = $product;
            }
        }

        return $mappedItems;
    }
}
