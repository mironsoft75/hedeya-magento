<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\RokanBrand\Block\Adminhtml\Brand\Edit;

class Tabs extends \Rokanthemes\Brand\Block\Adminhtml\Brand\Edit\Tabs
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->removeTab( 'products' );
    }
}
