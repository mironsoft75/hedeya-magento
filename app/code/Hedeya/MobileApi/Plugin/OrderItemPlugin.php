<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Plugin; 

class OrderItemPlugin
{
    private $extensionFactory;

    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
    ){
        $this->extensionFactory = $extensionFactory;
    }

    public function afterGetExtensionAttributes(
        \Magento\Sales\Model\Order\Item $orderItem,
        \Magento\Sales\Api\Data\OrderItemExtensionInterface $extensionAttributes = null
    ){
        if(is_null($extensionAttributes)) {
            $extensionAttributes = $this->extensionFactory->create(get_class($orderItem));
        }
        $extensionAttributes->setItemData(
            new \Hedeya\MobileApi\Model\Data\QuoteItem($orderItem)
        );
        return $extensionAttributes;
    }
}
