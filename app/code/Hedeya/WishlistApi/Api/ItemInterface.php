<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\WishlistApi\Api;

interface ItemInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProduct(): \Magento\Catalog\Api\Data\ProductInterface;
}
