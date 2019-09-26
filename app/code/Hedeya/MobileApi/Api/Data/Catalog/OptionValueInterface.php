<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data\Catalog;

/**
 * @api
 */
interface OptionValueInterface
{
    /**
     * @return string
     */
    public function getLabel();
    
    /**
     * @return string
     */
    public function getValue();
}
