<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data\Cart;

interface ItemOptionInterface
{
    /**
     * @return int
     */
    public function getValue();

    /**
     * @return string
     */
    public function getLabel();

}
