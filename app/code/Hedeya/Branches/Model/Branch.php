<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Model;

use Hedeya\Branches\Api\Data\BranchInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Branch extends AbstractModel implements BranchInterface, IdentityInterface
{
    const CACHE_TAG = 'hedeya_branch';
    
    protected $_cacheTag = 'hedeya_branch';
    protected $_eventPrefix = 'hedeya_branch';

    protected function _construct()
    {
        $this->_init('Hedeya\Branches\Model\ResourceModel\Branch');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->getData(self::BRANCH_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::BRANCH_ID, $id);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function getLatitude()
    {
        return $this->getData(self::LAT);
    }

    public function setLatitude($lat)
    {
        return $this->setData(self::LAT, $lat);
    }

    public function getLongitude()
    {
        return $this->getData(self::LNG);
    }

    public function setLongitude($lng)
    {
        return $this->setData(self::LNG, $lng);
    }

    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }
}
