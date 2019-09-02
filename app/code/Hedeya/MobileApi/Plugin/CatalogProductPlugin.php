<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Plugin; 

class CatalogProductPlugin
{
    public function __construct(
        \Hedeya\MobileApi\Helper\ProductExtension $helper
    ){
        $this->helper = $helper;
    }

    // for any products/:sku
    public function afterLoad(
        \Magento\Catalog\Api\Data\ProductInterface $subject,
        $results,
        $modelId,
        $field = null
    ){
        $results->setExtensionAttributes(
            $this->helper->getExtensionAttributes($subject)
        );
        return $results;
    }

    // to make sure it's loaded anywhere
    public function afterGetName(
        \Magento\Catalog\Model\Product $subject,
        $results
    ) {
        $subject->setExtensionAttributes(
            $this->helper->getExtensionAttributes($subject)
        );
        return $results;
    }

    // public function afterGetExtensionAttributes(
    //     \Magento\Catalog\Api\Data\ProductInterface $subject,
    //     \Magento\Catalog\Api\Data\ProductExtensionInterface $extensionAttributes = null
    // ){
    //     return $this->helper->getExtensionAttributes($subject);
    // }
}
