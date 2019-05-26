<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Helper;

use Magento\Framework\DataObject;
use Magento\Swatches\Model\Swatch as SwatchModel;
use Magento\Catalog\Model\Layer\Filter\FilterInterface as MagentoFilterInterface;


class CatalogData extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $objectManager;
    protected $storeManager;
    protected $layerResolver;
    protected $swatchHelper;
    protected $swatchMediaHelper;
    protected $eavConfig;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Swatches\Helper\Data $swatchHelper,
        \Magento\Swatches\Helper\Media $swatchMediaHelper,
        \Magento\Eav\Model\Config $eavConfig
    ) {
        $this->objectManager = $objectManager;
        $this->storeManager = $storeManager;
        $this->layerResolver = $layerResolver;
        $this->swatchHelper = $swatchHelper;
        $this->swatchMediaHelper = $swatchMediaHelper;
        $this->eavConfig = $eavConfig;
        parent::__construct($context);
    }

    /**
     * @todo: should dynamic this part
     * $category->getAvailableSortBy()
     * $category->getAvailableSortByOptions()
     */
    public function getSortersByCategoryId($categoryId)
    {
        $data['direction'] = [
            [
                'value' => 'asc',
                'label' => __('Ascending'),
            ],
            [
                'value' => 'desc',
                'label' => __('Descending'),
            ],
        ];
        $data['page_size'] = [
            12,
            20,
            40,
        ];
        $data['sort_by'] = [
            [
                'value' => 'position',
                'label' => __('Position'),
            ],
            [
                'value' => 'name',
                'label' => __('Name'),
            ],
            [
                'value' => 'price',
                'label' => __('Price'),
            ],
        ];
        return new DataObject($data);
    }

    public function getFiltersByCategoryId($categoryId)
    {
        $layer = $this->layerResolver->get()->setCurrentCategory($categoryId);
        $filters = $this->getLayerFilters($layer);
        foreach ($filters as $filter) {
            // exclude category attribute from filter attributes
            $isCategoryAttribute = preg_match('/Category/', get_class($filter));
            $isEmpty = !$filter->getItemsCount();
            if($isCategoryAttribute OR $isEmpty)
                continue;

            // get filter attribute
            $attribute = $filter->getAttributeModel();
            $attributeId = $attribute->getId();
            $attributeCode = $attribute->getAttributeCode();
            $filterLabel = $attribute->getStoreLabel();

            // start declaring filter data
            $filterIsSwatch = $filterSwatchTypeId = false;
            $filterOptionIds = $filterOptions = [];
            // extract available attribute option ids
            $filterItems = $filter->getItems();
            array_walk($filterItems, function($option) use (&$filterOptionIds, $attributeId) {
                $filterOptionIds[$attributeId][] = (int) $option->getValueString();
            });

            // prepare filter options
            $options = $attribute->getOptions();
            foreach ($options as $optionId => $option) {
                $withResults = isset($filterOptionIds[$attributeId]) && in_array($option->getValue(), $filterOptionIds[$attributeId]);
                if(!$optionId || !$withResults)
                    continue;
                $optionValueId = $option->getValue();
                $optionValueLabel = $option->getLabel();
                $filterOptions[$optionId] = [
                    'value' => $optionValueId,
                    'label' => $optionValueLabel,
                ];
                $swatch = $this->swatchHelper->getSwatchesByOptionsId([$optionValueId]);
                if($swatch && isset($swatch[$optionValueId]['value'])) {
                    $filterSwatchTypeId = $swatch[$optionValueId]['type'];
                    $filterIsSwatch = true;
                    $optionValueSwatch = $swatch[$optionValueId]['value'];
                    $filterOptions[$optionId]['swatch'] = $optionValueSwatch;
                }
            }
            // set filter type according to attribute code
            switch ((int) $filterSwatchTypeId) {
                case SwatchModel::SWATCH_TYPE_VISUAL_COLOR:
                    $filterType = 'color';
                    break;
                case SwatchModel::SWATCH_TYPE_VISUAL_IMAGE:
                    $filterType = 'image';
                    break;
                case SwatchModel::SWATCH_TYPE_EMPTY:
                case SwatchModel::SWATCH_TYPE_TEXTUAL:
                default:
                    $filterType = 'list';
                    break;
            }

            // check if custom attribute (price) to set min & max
            if("price" == $attributeCode && empty($filterOptions)) {
                $filterOptions = $this->getFilterPriceRanges($filter);
            }

            $data = [
                'id' => $attributeId,
                'code' => $attributeCode,
                'label' => $filterLabel,
                'type' => $filterType,
                'is_swatch' => $filterIsSwatch,
                'options' => $filterOptions,

            ];
            $catalogFilters[] = new DataObject($data);
        }
        
        return $catalogFilters ?? [];
    }
    
    protected function getLayerFilters($layer)
    {
        $filterList = $this->objectManager->create(
            'Magento\Catalog\Model\Layer\FilterList', 
            [
                'filterableAttributes' => $this->objectManager->get('Magento\Catalog\Model\Layer\Category\FilterableAttributeList'),
            ]
        );
        $filters = $filterList->getFilters($layer);
        return $filters;
    }

    protected function getFilterPriceRanges(MagentoFilterInterface $filter)
    {
        $minPrice = $filter->getLayer()->getProductCollection()->getMinPrice();
        $maxPrice = $filter->getLayer()->getProductCollection()->getMaxPrice();
        $minPriceValue = round($minPrice, 0, PHP_ROUND_HALF_DOWN);
        $maxPriceValue = round($maxPrice, 0, PHP_ROUND_HALF_UP);
        $priceHelper = $this->objectManager->create('Magento\Framework\Pricing\Helper\Data');
        $ranges = [
            [
                'value' => $minPriceValue,
                'label' => $priceHelper->currency($minPriceValue, true, false),
            ],
            [
                'value' => $maxPriceValue,
                'label' => $priceHelper->currency($maxPriceValue, true, false),
            ],
        ];
        return $ranges;
    }

}
