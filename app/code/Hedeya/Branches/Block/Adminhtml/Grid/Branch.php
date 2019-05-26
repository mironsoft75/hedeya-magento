<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Block\Adminhtml\Grid;

class Branch extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected $_controller = 'hedeya_branches';

    const PARAM_BUTTON_NEW = null;
    const PARAM_BUTTON_BACK = null;

    protected function _construct()
    {
        $this->_controller = 'adminhtml';
        $this->_blockGroup = 'Hedeya_Branches';
        $this->_headerText = __('Messages Inbox');
        parent::_construct();
        $this->buttonList->remove('add');
        $this->addButton(
            'export',
            [
                'label' => __('Export'),
                'onclick' => 'setLocation(\'' . $this->getExportUrl() . '\')',
                'class' => 'export primary'
            ]
        );
        $this->addButton(
            'import',
            [
                'label' => __('Import'),
                'onclick' => 'setLocation(\'' . $this->getImportUrl() . '\')',
                'class' => 'import action-secondary'
            ]
        );
    }

    public function getExportUrl()
    {
        return $this->getUrl('*/*/export');
    }

    public function getImportUrl()
    {
        return $this->getUrl('*/*/import');
    }




}
