<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\WishlistApi\Api;

use Hedeya\WishlistApi\Api\WishlistInterface;

interface WishlistRepositoryInterface
{
    /**
     * @param int $customerId
     * @return \Hedeya\WishlistApi\Api\WishlistInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByCustomerId($customerId): WishlistInterface;

    /**
     * @param string $sku
     * @return bool
     */
    public function addItem(string $sku): bool;

    /**
     * @param int $itemId
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException If item with the specified ID does not exist.
     */
    public function removeItem(int $itemId): bool;

    /**
     * Get the current customers wishlist
     *
     * @return \Hedeya\WishlistApi\Api\WishlistInterface
     * @throws NoSuchEntityException
     */
    public function getCurrentWishlist(): WishlistInterface;
}
