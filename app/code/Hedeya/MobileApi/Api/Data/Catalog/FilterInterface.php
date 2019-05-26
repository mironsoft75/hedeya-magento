<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data\Catalog;

interface FilterInterface
{
    /**
     * @return int
     */
    public function getId();
    
    /**
     * @return string
     */
    public function getCode();
    
    /**
     * @return string
     */
    public function getLabel();
    
    /**
     * @return string
     */
    public function getType();
    
    /**
     * @return bool
     */
    public function getIsSwatch();
    
    /**
     * @return \Hedeya\MobileApi\Api\Data\Catalog\FilterOptionInterface[]
     */
    public function getOptions();
    
}
