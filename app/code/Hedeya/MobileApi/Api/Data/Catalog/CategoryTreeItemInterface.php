<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data\Catalog;

interface CategoryTreeItemInterface
{
    /**#@+
     * Constants
     */
    const KEY_PARENT_ID = 'parent_id';
    const KEY_NAME = 'name';
    const KEY_IS_ACTIVE = 'is_active';
    const KEY_POSITION = 'position';
    const KEY_LEVEL = 'level';
    const KEY_UPDATED_AT = 'updated_at';
    const KEY_CREATED_AT = 'created_at';
    const KEY_PATH = 'path';
    const KEY_AVAILABLE_SORT_BY = 'available_sort_by';
    const KEY_INCLUDE_IN_MENU = 'include_in_menu';
    const KEY_PRODUCT_COUNT = 'product_count';
    const KEY_CHILDREN_DATA = 'children_data';
    const KEY_NESTED_CHILDREN = 'children_data';
    /**#@-*/

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return int|null
     */
    public function getParentId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return bool|null
     */
    public function getIsActive();

    /**
     * @return int|null
     */
    public function getPosition();

    /**
     * @return int|null
     */
    public function getLevel();

    /**
     * @return bool|null
     */
    public function getIncludeInMenu();
    
    /**
     * @return \Magento\Framework\Api\AttributeInterface[]|null
     */
    public function getAttributes();

    /**
     * @return \Hedeya\MobileApi\Api\Data\Catalog\CategoryTreeItemInterface[]
     */
    public function getNestedChildren();
}
