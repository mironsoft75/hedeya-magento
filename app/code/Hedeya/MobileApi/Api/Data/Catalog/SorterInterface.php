<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data\Catalog;

interface SorterInterface
{
    /**
     * @return \Magento\Framework\Option\ArrayInterface[]
     */
    public function getDirection();

    /**
     * @return \Magento\Framework\Option\ArrayInterface[]
     */
    public function getPageSize();

    /**
     * @return \Magento\Framework\Option\ArrayInterface[]
     */
    public function getSortBy();
}
