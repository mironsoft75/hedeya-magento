<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data;

interface QuoteItemInterface
{
    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return string|null
     */
    public function getProductImage();

    /**
     * @return  Hedeya\MobileApi\Api\Data\OptionItemInterface[]|null
     */
    public function getCustomOptions();

    /**
     * @return Hedeya\MobileApi\Api\Data\Cart\ItemOptionInterface[]|null
     */
    public function getConfigurableOptions();

}
