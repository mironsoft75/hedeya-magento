<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Model\Data; 

use Magento\Framework\DataObject;

class QuoteItem implements \Hedeya\MobileApi\Api\Data\QuoteItemInterface
{
    private $product;

    public function __construct(
        \Magento\Framework\Api\ExtensibleDataInterface $cartItem
    ){
        $this->product = $cartItem->getProduct();
    }

    public function getProductId()
    {
        return $this->product->getId();
    }

    public function getProductImage()
    {
        return $this->product->getImage() ?? $this->product->getThumbnail();
    }

    public function getCustomOptions()
    {
        if($this->product->hasCustomOptions()) {
            $customOptionsData = [];
            $customOptions = $this->product->getProductOptionsCollection(
                $this->product
            );
            foreach ($customOptions as $option) {
                $optionId = $option->getId();
                $optionLabel = $option->getTitle() ?? $option->getDefaultTitle();
                $values = $option->getValues();
                $options = [];
                foreach ($values as $value) {
                    $options[] = new DataObject([
                        'id' => $value->getOptionTypeId(),
                        'value' => $value->getTitle() ?? $value->getDefaultTitle(),
                    ]);
                }
                $customOptionsData[] = new DataObject([
                    'id' => $optionId,
                    'label' => $option->getTitle() ?? $option->getDefaultTitle(),
                    'options' => $options,
                ]);

            }
        }

        if(!empty($customOptionsData)) {
            return $customOptionsData;

        }
    }

    public function getConfigurableOptions()
    {
        if($attributesOption = $this->product->getCustomOption('attributes')) {
            $configurableOptions = [];
            $options = json_decode($attributesOption->getValue(), true);
            $configurableOptionValues = $this->getEavAttributeOptionValue($options);
            foreach ($configurableOptionValues as $configurableOptionData) {
                $data = [
                    'value' => $configurableOptionData['option_id'],
                    'label' => $configurableOptionData['value'],
                ];
                $configurableOptions[] = new DataObject($data);
            }
            return $configurableOptions;
        }
    }

    private function getEavAttributeOptionValue(array $optionIds = [])
    {
        if($optionIds) {
            $optionIds = implode(', ', $optionIds);
            $storeIds = implode(', ', [0]);
            $sql = "SELECT * FROM eav_attribute_option_value WHERE option_id IN ({$optionIds}) AND store_id IN ({$storeIds})";
            if($results = $this->getResourceConnection()->fetchAll($sql)) {
                return $results;
            }
        }
    }

    private function getResourceConnection()
    {
        return $this->product->getResource()->getConnection();
    }
}
