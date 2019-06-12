<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\AutoProductLinks\Observer;

use Magento\Catalog\Model\Category;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddProductLinks implements ObserverInterface
{
    private const EXCLUDED_CATEGORY_PATHS = [
        '1/2/85'
    ];

    private const MAIN_CATEGORY_LEVEL = 2;

    private $productLinkFactory;

    public function __construct(
        \Magento\Catalog\Api\Data\ProductLinkInterfaceFactory $productLinkFactory
    )
    {
        $this->productLinkFactory = $productLinkFactory;
    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $currentProduct */
        $currentProduct = $observer->getProduct();

        /** @var \Magento\Catalog\Api\Data\ProductLinkInterface[] $links */
        $links = [];

        $categories = $currentProduct->getCategoryCollection();

        /** @var Category $subCategory */
        $subCategory = null;
        /** @var Category $mainCategory */
        $mainCategory = null;

        $subCategoryLevel = self::MAIN_CATEGORY_LEVEL;

        foreach ($categories as $category) {
            foreach (self::EXCLUDED_CATEGORY_PATHS as $excludedCategoryPath) {
                if (false !== stripos($category->getPath(), $excludedCategoryPath)) {
                    continue 2;
                }
            }

            if ($category->getLevel() == self::MAIN_CATEGORY_LEVEL) {
                $mainCategory = $category;
            }

            if ($category->getLevel() >= $subCategoryLevel) {
                $subCategory = $category;
                $subCategoryLevel = $category->getLevel();
            }
        }

        if (null !== $subCategory) {
            $relatedProductsCollection = $this->_getCategoryRandomProducts($subCategory, 10);
            $links = array_merge($links, $this->_generateProductLinks($currentProduct, $relatedProductsCollection, 'related'));
        }

        if (null !== $mainCategory) {
            $upsellProductsCollection = $this->_getCategoryRandomProducts($mainCategory, 10);
            $links = array_merge($links, $this->_generateProductLinks($currentProduct, $upsellProductsCollection, 'upsell'));
        }

        $currentProduct->setProductLinks($links);
    }

    private function _getCategoryRandomProducts($category, $numberOfProducts)
    {
        $productsCollection = $category->getProductCollection()
            ->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
            ->setPageSize($numberOfProducts);
        $productsCollection->getSelect()->orderRand();
        return $productsCollection;
    }

    private function _generateProductLinks($mainProduct, $productsCollection, $linkType)
    {
        $links = [];
        $index = 1;
        foreach ($productsCollection as $product) {
            $productLink = $this->productLinkFactory->create()
                ->setSku($mainProduct->getSku())
                ->setLinkedProductSku($product->getSku())
                ->setPosition($index)
                ->setLinkType($linkType);

            $index++;
            $links[] = $productLink;
        }

        return $links;
    }
}
