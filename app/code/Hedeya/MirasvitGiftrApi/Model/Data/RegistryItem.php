<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Model\Data;

use Hedeya\MirasvitGiftrApi\Api\Data\RegistryItemInterface;
use Mirasvit\Giftr\Model\Item;
use Magento\Framework\DataObject;

class RegistryItem extends DataObject implements RegistryItemInterface
{
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::KEY_ID);
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getRegistryId()
    {
        return $this->getData(self::KEY_REGISTRY_ID);
    }

    /**
     * @inheritdoc
     */
    public function setRegistryId($registryId)
    {
        return $this->setData(self::KEY_REGISTRY_ID, $registryId);
    }

    /**
     * @inheritdoc
     */
    public function getRegistryUid()
    {
        return $this->getData(self::KEY_REGISTRY_UID);
    }

    /**
     * @inheritdoc
     */
    public function setRegistryUid($registryUid)
    {
        return $this->setData(self::KEY_REGISTRY_UID, $registryUid);
    }

    /**
     * @inheritdoc
     */
    public function getProductId()
    {
        return $this->getData(self::KEY_PRODUCT_ID);
    }

    /**
     * @inheritdoc
     */
    public function setProductId($productId)
    {
        return $this->setData(self::KEY_PRODUCT_ID, $productId);
    }

    /**
     * @inheritdoc
     */
    public function getSku()
    {
        return $this->getData(self::KEY_SKU);
    }

    /**
     * @inheritdoc
     */
    public function setSku($sku)
    {
        return $this->setData(self::KEY_SKU, $sku);
    }

    /**
     * @inheritdoc
     */
    public function getPriorityId()
    {
        return $this->getData(self::KEY_PRIORITY_ID);
    }

    /**
     * @inheritdoc
     */
    public function setPriorityId($priorityId)
    {
        return $this->setData(self::KEY_PRIORITY_ID, $priorityId);
    }

    /**
     * @inheritdoc
     */
    public function getPriorityName()
    {
        return $this->getData(self::KEY_PRIORITY_NAME);
    }

    /**
     * @inheritdoc
     */
    public function setPriorityName($priorityName)
    {
        return $this->setData(self::KEY_PRIORITY_NAME, $priorityName);
    }

    /**
     * @inheritdoc
     */
    public function getQty()
    {
        return $this->getData(self::KEY_QTY);
    }

    /**
     * @inheritdoc
     */
    public function setQty($qty)
    {
        return $this->setData(self::KEY_QTY, $qty);
    }

    /**
     * @inheritdoc
     */
    public function getQtyOrdered()
    {
        return $this->getData(self::KEY_QTY_ORDERED);
    }

    /**
     * @inheritdoc
     */
    public function setQtyOrdered($qtyOrdered)
    {
        return $this->setData(self::KEY_QTY_ORDERED, $qtyOrdered);
    }

    /**
     * @inheritdoc
     */
    public function getQtyReceived()
    {
        return $this->getData(self::KEY_QTY_RECEIVED);
    }

    /**
     * @inheritdoc
     */
    public function setQtyReceived($qtyReceived)
    {
        return $this->setData(self::KEY_QTY_RECEIVED, $qtyReceived);
    }

    /**
     * @inheritdoc
     */
    public function getNote()
    {
        return $this->getData(self::KEY_NOTE);
    }

    /**
     * @inheritdoc
     */
    public function setNote($note)
    {
        return $this->setData(self::KEY_NOTE, $note);
    }
}
