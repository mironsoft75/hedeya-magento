<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\WishlistApi\Api;

interface WishlistInterface
{
    /**
     * @return int
     */
    public function getItemsCount();

    /**
     * @return \Hedeya\WishlistApi\Api\ItemInterface[]
     */
    public function getItems();

    /**
     * @param int $itemId
     * @return false|Item
     */
    public function getItem($itemId);

    /**
     * Adds new product to wishlist.
     * Returns new item or string on error.
     *
     * @param int|\Magento\Catalog\Model\Product $product
     * @param \Magento\Framework\DataObject|array|string|null $buyRequest
     * @param bool $forciblySetQty
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return Item|string
     */
    public function addNewItem($product, $buyRequest = null, $forciblySetQty = false);
}
