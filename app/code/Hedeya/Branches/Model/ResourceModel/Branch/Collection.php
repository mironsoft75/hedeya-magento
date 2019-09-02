<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Model\ResourceModel\Branch;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'branch_id';

    protected function _construct()
    {
        $this->_init('Hedeya\Branches\Model\Branch', 'Hedeya\Branches\Model\ResourceModel\Branch');
    }
}
