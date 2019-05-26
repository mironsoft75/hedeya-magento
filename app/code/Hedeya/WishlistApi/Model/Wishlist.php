<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\WishlistApi\Model;

class Wishlist extends \Magento\Wishlist\Model\Wishlist implements \Hedeya\WishlistApi\Api\WishlistInterface
{
    /**
     * @inheritdoc
     */
    public function getItems()
    {
        return $this->getItemCollection()->getItems();
    }
}
