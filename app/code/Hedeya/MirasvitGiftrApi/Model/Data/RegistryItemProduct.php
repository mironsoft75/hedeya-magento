<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Model\Data;

class RegistryItemProduct implements \Hedeya\MirasvitGiftrApi\Api\Data\RegistryItemProductInterface
{
    private $node;

    public function __construct(
        \Mirasvit\Giftr\Model\Item $node
    ){
        $this->node = $node;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->node->getId();
    }
    
    /**
     * @inheritdoc
     */
    public function getRegistryId()
    {
        return $this->node->getRegistryId();
    }

    /**
     * @inheritdoc
     */
    public function getRegistryUid()
    {
        return $this->node->getRegistry()->getUid();
    }
    
    /**
     * @inheritdoc
     */
    public function getSku()
    {
        return $this->node->getSku();
    }

    /**
     * @inheritdoc
     */
    public function getProductId()
    {
        return $this->node->getProductId();
    }
    
    /**
     * @inheritdoc
     */
    public function getPriorityId()
    {
        return $this->node->getPriorityId();
    }
    
    /**
     * @inheritdoc
     */
    public function getPriorityName()
    {
        return $this->node->getPriorityName();
    }
    
    /**
     * @inheritdoc
     */
    public function getQty()
    {
        return $this->node->getQty();
    }
    
    /**
     * @inheritdoc
     */
    public function getQtyOrdered()
    {
        return $this->node->getQtyOrdered();
    }
    
    /**
     * @inheritdoc
     */
    public function getQtyReceived()
    {
        return $this->node->getQtyReceived();
    }
    
    /**
     * @inheritdoc
     */
    public function getNote()
    {
        return $this->node->getNote();
    }
}
