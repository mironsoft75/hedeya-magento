<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Plugin; 

class CartItemPlugin
{
    private $extensionFactory;

    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
    ){
        $this->extensionFactory = $extensionFactory;
    }

    public function afterGetExtensionAttributes(
        \Magento\Quote\Model\Quote\Item $cartItem,
        \Magento\Quote\Api\Data\CartItemExtensionInterface $extensionAttributes = null
    ){
        if(is_null($extensionAttributes)) {
            $extensionAttributes = $this->extensionFactory->create(get_class($cartItem));
        }
        $extensionAttributes->setItemData(
            new \Hedeya\MobileApi\Model\Data\QuoteItem($cartItem)
        );
        return $extensionAttributes;
    }
}
