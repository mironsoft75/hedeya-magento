<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-gift-registry
 * @version   1.2.10
 * @copyright Copyright (C) 2018 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\Giftr\Block\Adminhtml\Priority;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @param \Magento\Framework\Registry           $registry
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->_objectId = 'priority_id';
        $this->_controller = 'adminhtml_priority';
        $this->_blockGroup = 'Mirasvit_Giftr';

        $this->buttonList->remove('save');

        $this->getToolbar()->addChild(
            'update-split-button',
            'Magento\Backend\Block\Widget\Button\SplitButton',
            [
                'label'   => __('Save'),
                'options' => [
                    [
                        'label'          => __('Save'),
                        'default'        => true,
                        'data_attribute' => [
                            'mage-init' => [
                                'button' => [
                                    'event'  => 'save',
                                    'target' => '#edit_form'
                                ]
                            ]
                        ]
                    ],
                    [
                        'label'          => __('Save & Continue Edit'),
                        'data_attribute' => [
                            'mage-init' => [
                                'button' => [
                                    'event'  => 'saveAndContinueEdit',
                                    'target' => '#edit_form'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        );

        return $this;
    }

    public function getPriority()
    {
        if ($this->registry->registry('current_priority') && $this->registry->registry('current_priority')->getId()) {
            return $this->registry->registry('current_priority');
        }
    }

    public function getHeaderText()
    {
        if ($priority = $this->getPriority()) {
            return __("Edit Priority '%1'", $this->escapeHtml($priority->getName()));
        } else {
            return __('Create New Priority');
        }
    }

    /************************/
}
