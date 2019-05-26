<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Model\Config\Source;

class ChildCategory extends \Magento\Catalog\Model\Config\Source\Category
{
    const MAGENTO_CATEGORY_LEVEL = 2;

    public function toOptionArray($addEmpty = true, $levelFilter = 3)
    {
        $collection = $this->_categoryCollectionFactory->create();
        $rootCategoryId = 2; // todo: dynamic this part
        $collection->addAttributeToSelect('name')->addLevelFilter($levelFilter)->load();
        $options = [];
        if ($addEmpty || true) {
            $options[] = ['label' => __('-- Please Select a Category --'), 'value' => ''];
        }
        foreach ($collection as $category) {
            if($category->getId() > $rootCategoryId) {
                $level = $category->getLevel() - self::MAGENTO_CATEGORY_LEVEL;
                $navLabel = str_repeat("−", $level >= 0 ? $level : 0) . ($level ? ' ' : '');
                $options[] = [
                    'label' => $navLabel . $category->getName(),
                    'value' => $category->getId()
                ];
            }
        }
        return $options;
    }
}
