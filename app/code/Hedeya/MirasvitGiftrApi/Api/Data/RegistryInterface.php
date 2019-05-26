<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Api\Data;

interface RegistryInterface
{
    const KEY_ID = "id";
    const KEY_REGISTRY_ID = "registry_id";
    const KEY_UID = "uid";
    const KEY_NAME = "name";
    const KEY_ITEMS_COUNT = "items_count";
    const KEY_IS_ACTIVE = "is_active";
    const KEY_IS_PUBLIC = "is_public";
    const KEY_CUSTOMER = "customer";
    const KEY_CUSTOMER_ID = "customer_id";
    const KEY_TYPE_ID = "type_id";
    const KEY_TYPE = "type";
    const KEY_FIRSTNAME = "firstname";
    const KEY_MIDDLENAME = "middlename";
    const KEY_LASTNAME = "lastname";
    const KEY_EMAIL = "email";
    const KEY_CO_FIRSTNAME = "co_firstname";
    const KEY_CO_MIDDLENAME = "co_middlename";
    const KEY_CO_LASTNAME = "co_lastname";
    const KEY_CO_EMAIL = "co_email";
    const KEY_LOCATION = "location";
    const KEY_EVENT_AT = "event_at";
    const KEY_DESCRIPTION = "description";
    const KEY_IMAGE = "image";
    const KEY_SHIPPING_ADDRESS_ID = "shipping_address_id";
    const KEY_VALUES = "values";
    const KEY_PRODUCT_COLLECTION = "product_collection";
    const KEY_ORDER_IDS = "order_ids";

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
    // public function getRegistryId();

    /**
     * @param int $registryId
     * @return self
     */
    // public function setRegistryId($registryId);

    /**
     * @return string
     */
    public function getUid();

    /**
     * @param string $uid
     * @return self
     */
    public function setUid($uid);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return self
     */
    public function setName($name);

    /**
     * @return bool
     */
    public function getIsActive();

    /**
     * @param bool $isActive
     * @return self
     */
    public function setIsActive($isActive);

    /**
     * @return bool
     */
    public function getIsPublic();

    /**
     * @param bool $isPublic
     * @return self
     */
    public function setIsPublic($isPublic);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $customerId
     * @return self
     */
    public function setCustomerId($customerId);

    /**
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    // public function getCustomer();

    /**
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return self
     */
    // public function setCustomer($customer);
    
    /**
     * @return int
     */
    public function getTypeId();

    /**
     * @param int $typeId
     * @return self
     */
    public function setTypeId($typeId);

    /**
     * @return string|null
     */
    public function getFirstname();

    /**
     * @param string $firstname
     * @return self
     */
    public function setFirstname($firstname);

    /**
     * @return string|null
     */
    public function getMiddlename();

    /**
     * @param string $middlename
     * @return self
     */
    public function setMiddlename($middlename);

    /**
     * @return string|null
     */
    public function getLastname();

    /**
     * @param string $lastname
     * @return self
     */
    public function setLastname($lastname);

    /**
     * @return string|null
     */
    public function getEmail();

    /**
     * @param string $email
     * @return self
     */
    public function setEmail($email);

    /**
     * @return string|null
     */
    public function getCoFirstname();

    /**
     * @param string $coFirstname
     * @return self
     */
    public function setCoFirstname($coFirstname);
    
    /**
     * @return string|null
     */
    public function getCoMiddlename();

    /**
     * @param string $coMiddlename
     * @return self
     */
    public function setCoMiddlename($coMiddlename);
    
    /**
     * @return string|null
     */
    public function getCoLastname();

    /**
     * @param string $coLastname
     * @return self
     */
    public function setCoLastname($coLastname);
    
    /**
     * @return string|null
     */
    public function getCoEmail();

    /**
     * @param string $coEmail
     * @return self
     */
    public function setCoEmail($coEmail);

    /**
     * @return string|null
     */
    public function getLocation();

    /**
     * @param string $location
     * @return self
     */
    public function setLocation($location);

    /**
     * @return string|null
     */
    public function getEventAt();

    /**
     * @param string $eventAt
     * @return self
     */
    public function setEventAt($eventAt);

    /**
     * @return string|null
     */
    public function getDescription();

    /**
     * @param string $description
     * @return self
     */
    public function setDescription($description);

    /**
     * @return int|null
     */
    public function getShippingAddressId();

    /**
     * @param int $shippingAddressId
     * @return self
     */
    public function setShippingAddressId($shippingAddressId);

    /**
     * @return string|null
     */
    public function getImage();

    /**
     * @param string $image
     * @return self
     */
    public function setImage($image);

    /**
     * @return int
     */
    public function getItemsCount();

    /**
     * @param int $itemsCount
     * @return self
     */
    public function setItemsCount($itemsCount);

}
