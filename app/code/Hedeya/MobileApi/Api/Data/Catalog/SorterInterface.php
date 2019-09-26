<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data\Catalog;

interface SorterInterface
{
    /**
     * @return \Magento\Framework\Data\OptionSourceInterface[]
     */
    public function getDirection();

    /**
     * @return \Magento\Framework\Data\OptionSourceInterface[]
     */
    public function getPageSize();

    /**
     * @return \Magento\Framework\Data\OptionSourceInterface[]
     */
    public function getSortBy();
}
