<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data\Catalog;

interface FilterOptionInterface extends \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return string
     */
    public function getSwatch();
}
