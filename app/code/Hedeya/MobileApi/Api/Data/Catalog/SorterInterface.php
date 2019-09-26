<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data\Catalog;

interface SorterInterface
{
    /**
     * @return \Hedeya\MobileApi\Api\Data\Catalog\OptionValueInterface[]
     */
    public function getDirection();

    /**
     * @return int[]
     */
    public function getPageSize();

    /**
     * @return \Hedeya\MobileApi\Api\Data\Catalog\OptionValueInterface[]
     */
    public function getSortBy();
}
