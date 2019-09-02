<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Api\Data;

interface RegistryItemInterface
{
    const KEY_ID = "id";
    const KEY_REGISTRY_ID = "registry_id";
    const KEY_REGISTRY_UID = "registry_uid";
    const KEY_PRODUCT_ID = "product_id";
    const KEY_SKU = "sku";
    const KEY_PRIORITY_ID = "priority_id";
    const KEY_PRIORITY_NAME = "priority_name";
    const KEY_QTY = "qty";
    const KEY_QTY_ORDERED = "qty_ordered";
    const KEY_QTY_RECEIVED = "qty_received";
    const KEY_NOTE = "note";

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return self
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getRegistryId();

    /**
     * @param int $registryId
     * @return self
     */
    public function setRegistryId($registryId);

    /**
     * @return string
     */
    public function getRegistryUid();

    /**
     * @param string $registryUid
     * @return self
     */
    public function setRegistryUid($registryUid);
    
    /**
     * @return int
     */
    public function getProductId();

    /**
     * @param int $productId
     * @return self
     */
    public function setProductId($productId);

    /**
     * @return string|null
     */
    public function getSku();

    /**
     * @param string $productSku
     * @return self
     */
    public function setSku($productSku);

    /**
     * @return int|null
     */
    public function getPriorityId();

    /**
     * @param int $priorityId
     * @return self
     */
    public function setPriorityId($priorityId);
    
    /**
     * @return string|null
     */
    public function getPriorityName();

    /**
     * @param string $priorityName
     * @return self
     */
    public function setPriorityName($priorityName);

    /**
     * @return int|null
     */
    public function getQty();

    /**
     * @param int $qty
     * @return self
     */
    public function setQty($qty);
    
    /**
     * @return int|null
     */
    public function getQtyOrdered();

    /**
     * @param int $qtyOrdered
     * @return self
     */
    public function setQtyOrdered($qtyOrdered);
    
    /**
     * @return int|null
     */
    public function getQtyReceived();

    /**
     * @param int $qtyReceived
     * @return self
     */
    public function setQtyReceived($qtyReceived);
    
    /**
     * @return string
     */
    public function getNote();

    /**
     * @param string $note
     * @return self
     */
    public function setNote($note);
}
