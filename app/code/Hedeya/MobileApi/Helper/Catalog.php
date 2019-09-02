<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Helper;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductAttributeInterface;

class Catalog extends \Magento\Framework\App\Helper\AbstractHelper
{
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Search\Model\AutocompleteInterface $autocomplete,
        \Magento\Search\Model\QueryFactory $queryFactory,
        \Magento\Search\Helper\Data $searchHelper,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Hedeya\MobileApi\Helper\Data $dataHelper
    ){
        $this->storeManager = $storeManager;
        $this->categoryFactory = $categoryFactory;
        $this->autocomplete = $autocomplete;
        $this->queryFactory = $queryFactory;
        $this->searchHelper = $searchHelper;
        $this->objectManager = $objectManager;
        $this->dataHelper = $dataHelper;
        parent::__construct($context);
    }

    public function getSearchSuggestionsByQuery(string $query = null)
    {
        $query = $this->queryFactory->get();
        $autocompleteItems = $this->autocomplete->getItems();
        if ($query->getQueryText() != '') {
            if ($this->objectManager->get('Magento\CatalogSearch\Helper\Data')->isMinQueryLength()) {
                $query->setId(0)->setIsActive(1)->setIsProcessed(1);
            } else {
                $query->saveIncrementalPopularity();
                $query->saveNumResults(sizeof($autocompleteItems));
            }
        }
        return $autocompleteItems;
    }

    public function getBrandCategoryId()
    {
        return $this->dataHelper->getConfig('hedeya_configs/catalog/brands_catid');
    }

    public function getCatalogBrands()
    {
        $brands = [];
        if($categoryId = $this->getBrandCategoryId()) {
            $category = $this->categoryFactory->create()->load($categoryId);
            if($category->getId()) {
                $children = $category->getChildrenCategories()->addAttributeToSelect('mapi_category_icon');
                foreach ($children as $childId => $child) {
                    $brands[$childId] = [
                        'value' => $childId,
                        'label' => $child->getName(),
                    ];
                    if($childIconImage = $child->getData('mapi_category_icon'))
                        $brands[$childId]['swatch'] = $childIconImage;                 
                }
            }
        }
        return $brands;
    }

    public function getBrandsByProduct(ProductInterface $product)
    {
        $data = [];
        $catalogBrands = $this->getCatalogBrands();
        $categoryIds = $product->getCategoryIds();
        // get brand data for product from intersections
        $intersect = array_intersect(array_keys($catalogBrands), $categoryIds);
        foreach ($intersect as $categoryId) {
            $data[] = $catalogBrands[$categoryId];
        }
        return $data;
    }

    public function getAdditionalInformation(ProductInterface $product)
    {
        $data = [];
        $customAttributes = $product->getCustomAttributes();
        foreach ($customAttributes as $customAttribute) {
            $attribute = $product->getResource()
                                    ->getAttribute(
                                        $customAttribute->getAttributeCode()
                                    );
            if(!$this->showAttribute($attribute)) 
                continue;
            $data[] = [
                'code' => $attribute->getAttributeCode(),
                'label' => $attribute->getStoreLabel(),
                'value' => $attribute->getFrontend()->getValue($product),
            ];
        }
        return $data;
    }

    private function showAttribute(ProductAttributeInterface $attribute): bool
    {
        $visible = $attribute->getIsVisibleOnFront();
        $listed = in_array($attribute->getFrontendInput(), ['select', 'multiselect']);
        return $visible && $listed;
    }


}
