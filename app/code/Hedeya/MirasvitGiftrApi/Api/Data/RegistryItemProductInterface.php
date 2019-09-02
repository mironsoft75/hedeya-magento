<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Api\Data;

interface RegistryItemProductInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getRegistryId();

    /**
     * @return string
     */
    public function getRegistryUid();
    
    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return string|null
     */
    public function getSku();

    /**
     * @return int|null
     */
    public function getPriorityId();
    
    /**
     * @return string|null
     */
    public function getPriorityName();

    /**
     * @return int|null
     */
    public function getQty();
    
    /**
     * @return int|null
     */
    public function getQtyOrdered();
    
    /**
     * @return int|null
     */
    public function getQtyReceived();
    
    /**
     * @return string|null
     */
    public function getNote();
}
