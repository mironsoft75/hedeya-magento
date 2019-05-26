<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Model\Data;

use Hedeya\MirasvitGiftrApi\Api\Data\RegistryInterface;
use Mirasvit\Giftr\Model\Registry as RegistryBase;
use Magento\Framework\DataObject;

class Registry extends RegistryBase implements RegistryInterface
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
    public function getUid()
    {
        return $this->getData(self::KEY_UID);
    }

    /**
     * @inheritdoc
     */
    public function setUid($uid)
    {
        return $this->setData(self::KEY_UID, $uid);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->getData(self::KEY_NAME);
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        return $this->setData(self::KEY_NAME, $name);
    }

    /**
     * @inheritdoc
     */
    public function getIsActive()
    {
        return $this->getData(self::KEY_IS_ACTIVE);
    }

    /**
     * @inheritdoc
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::KEY_IS_ACTIVE, $isActive);
    }

    /**
     * @inheritdoc
     */
    public function getIsPublic()
    {
        return $this->getData(self::KEY_IS_PUBLIC);
    }

    /**
     * @inheritdoc
     */
    public function setIsPublic($isPublic)
    {
        return $this->setData(self::KEY_IS_PUBLIC, $isPublic);
    }

    /**
     * @inheritdoc
     */
    public function getCustomerId()
    {
        return $this->getData(self::KEY_CUSTOMER_ID);
    }

    /**
     * @inheritdoc
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::KEY_CUSTOMER_ID);
    }

    /**
     * @inheritdoc
     */
    public function getCustomer()
    {
        return $this->getData(self::KEY_CUSTOMER);
    }

    /**
     * @inheritdoc
     */
    public function setCustomer($customer)
    {
        return $this->setData(self::KEY_CUSTOMER);
    }

    /**
     * @inheritdoc
     */
    public function getTypeId()
    {
        return $this->getData(self::KEY_TYPE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setTypeId($typeId)
    {
        return $this->setData(self::KEY_TYPE_ID, $typeId);
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->getData(self::KEY_TYPE);
    }

    /**
     * @inheritdoc
     */
    public function setType($type)
    {
        return $this->setData(self::KEY_TYPE, $type);
    }

    /**
     * @inheritdoc
     */
    public function getFirstname()
    {
        return $this->getData(self::KEY_FIRSTNAME);
    }

    /**
     * @inheritdoc
     */
    public function setFirstname($firstname)
    {
        return $this->setData(self::KEY_FIRSTNAME, $firstname);
    }

    /**
     * @inheritdoc
     */
    public function getMiddlename()
    {
        return $this->getData(self::KEY_MIDDLENAME);
    }

    /**
     * @inheritdoc
     */
    public function setMiddlename($middlename)
    {
        return $this->setData(self::KEY_MIDDLENAME, $middlename);
    }

    /**
     * @inheritdoc
     */
    public function getLastname()
    {
        return $this->getData(self::KEY_LASTNAME);
    }

    /**
     * @inheritdoc
     */
    public function setLastname($lastname)
    {
        return $this->setData(self::KEY_LASTNAME, $lastname);
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return $this->getData(self::KEY_EMAIL);
    }

    /**
     * @inheritdoc
     */
    public function setEmail($email)
    {
        return $this->setData(self::KEY_EMAIL, $email);
    }

    /**
     * @inheritdoc
     */
    public function getCoFirstname()
    {
        return $this->getData(self::KEY_CO_FIRSTNAME);
    }

    /**
     * @inheritdoc
     */
    public function setCoFirstname($coFirstname)
    {
        return $this->setData(self::KEY_CO_FIRSTNAME, $coFirstname);
    }

    /**
     * @inheritdoc
     */
    public function getCoMiddlename()
    {
        return $this->getData(self::KEY_CO_MIDDLENAME);
    }

    /**
     * @inheritdoc
     */    
    public function setCoMiddlename($coMiddlename)
    {
        return $this->setData(self::KEY_CO_MIDDLENAME, $coMiddlename);
    }

    /**
     * @inheritdoc
     */
    public function getCoLastname()
    {
        return $this->getData(self::KEY_CO_LASTNAME);
    }

    /**
     * @inheritdoc
     */    
    public function setCoLastname($coLastname)
    {
        return $this->setData(self::KEY_CO_LASTNAME, $coLastname);
    }

    /**
     * @inheritdoc
     */
    public function getCoEmail()
    {
        return $this->getData(self::KEY_CO_EMAIL);
    }

    /**
     * @inheritdoc
     */    
    public function setCoEmail($coEmail)
    {
        return $this->setData(self::KEY_CO_EMAIL, $coEmail);
    }

    /**
     * @inheritdoc
     */
    public function getLocation()
    {
        return $this->getData(self::KEY_LOCATION);
    }

    /**
     * @inheritdoc
     */
    public function setLocation($location)
    {
        return $this->setData(self::KEY_LOCATION, $location);
    }

    /**
     * @inheritdoc
     */
    public function getEventAt()
    {
        return $this->getData(self::KEY_EVENT_AT);
    }

    /**
     * @inheritdoc
     */
    public function setEventAt($eventAt)
    {
        return $this->setData(self::KEY_EVENT_AT, $eventAt);
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->getData(self::KEY_DESCRIPTION);
    }

    /**
     * @inheritdoc
     */
    public function setDescription($description)
    {
        return $this->setData(self::KEY_DESCRIPTION, $description);
    }
    /**
     * @inheritdoc
     */
    public function getImage()
    {
        return $this->getData(self::KEY_IMAGE);
    }

    /**
     * @inheritdoc
     */
    public function setImage($image)
    {
        return $this->setData(self::KEY_IMAGE, $image);
    }

    /**
     * @inheritdoc
     */
    public function getShippingAddressId()
    {
        return $this->getData(self::KEY_SHIPPING_ADDRESS_ID);
    }

    /**
     * @inheritdoc
     */
    public function setShippingAddressId($shippingAddressId)
    {
        return $this->setData(self::KEY_SHIPPING_ADDRESS_ID, $shippingAddressId);
    }

    /**
     * @inheritdoc
     */
    public function getValues()
    {
        return $this->getData(self::KEY_VALUES);
    }

    /**
     * @inheritdoc
     */
    public function setValues($values)
    {
        return $this->setData(self::KEY_VALUES, $values);
    }

    /**
     * @inheritdoc
     */
    public function getProductCollection()
    {
        return $this->getData(self::KEY_PRODUCT_COLLECTION);
    }

    /**
     * @inheritdoc
     */
    public function setProductCollection($productCollection)
    {
        return $this->setData(self::KEY_PRODUCT_COLLECTION, $productCollection);
    }

    /**
     * @inheritdoc
     */
    public function getOrderIds()
    {
        return $this->getData(self::KEY_ORDER_IDS);
    }

    /**
     * @inheritdoc
     */
    public function setOrderIds($orderIds)
    {
        return $this->setData(self::KEY_ORDER_IDS, $orderIds);
    }

    /**
     * @inheritdoc
     */
    public function getItemsCount()
    {
        return $this->getData(self::KEY_ITEMS_COUNT);
    }

    /**
     * @inheritdoc
     */
    public function setItemsCount($itemsCount)
    {
        return $this->setData(self::KEY_ITEMS_COUNT, $itemsCount);
    }


}
 
