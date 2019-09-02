<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Model\Data; 

class CategoryTreeItem implements \Hedeya\MobileApi\Api\Data\Catalog\CategoryTreeItemInterface
{
    public function __construct(
        \Magento\Catalog\Api\Data\CategoryInterface $node,
        int $depth = null
    ){
        $this->node = $node;
        $this->depth = $depth;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->node->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getParentId()
    {
        $parentId = $this->node->getData(self::KEY_PARENT_ID);
        if (isset($parentId)) {
            return $parentId;
        }
        $parentIds = $this->node->getParentIds();
        return intval(array_pop($parentIds));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->node->getData(self::KEY_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsActive()
    {
        return $this->node->getData(self::KEY_IS_ACTIVE);
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->node->getData(self::KEY_POSITION);
    }

    /**
     * {@inheritdoc}
     */
    public function getLevel()
    {
        return $this->node->getData(self::KEY_LEVEL);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductCount()
    {
        $count = $this->node->hasData(self::KEY_PRODUCT_COUNT);
        if (!$count) {
            $count = $this->node->_getResource()->getProductCount($this->node);
        }
        return $count;
    }

    /**
     * {@inheritdoc}
     */
    public function getIncludeInMenu()
    {
        return $this->node->getData(self::KEY_INCLUDE_IN_MENU);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->node->getCustomAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function getNestedChildren()
    {
        return $this->getTree($this->node, $this->depth)->getNestedChildren();
    }

    protected function getTree($category, $depth = null, $currentLevel = 0)
    {
        $children = $this->getChildren($category, $depth, $currentLevel);
        $category->setNestedChildren($children);
        return $category;
    }

    protected function getChildren($category, $depth, $currentLevel)
    {
        if ($category->hasChildren()) {
            $children = [];
            foreach ($category->getChildrenCategories()->addAttributeToSelect('*') as $child) {
                if ($depth !== null && $depth <= $currentLevel) {
                    break;
                }
                $children[] = new \Hedeya\MobileApi\Model\Data\CategoryTreeItem($child, $depth);
                if($child->getData(self::KEY_INCLUDE_IN_MENU)) {
                    //
                }
            }
            return $children;
        }
        return [];
    }

}
