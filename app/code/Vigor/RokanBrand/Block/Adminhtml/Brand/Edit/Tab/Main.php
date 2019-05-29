<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\RokanBrand\Block\Adminhtml\Brand\Edit\Tab;

use Vigor\RokanBrand\Block\Adminhtml\Form\Element\CategoryOptions;

class Main extends \Rokanthemes\Brand\Block\Adminhtml\Brand\Edit\Tab\Main
{
    protected $_categoryOptions;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Rokanthemes\Brand\Helper\Data $viewHelper,
        CategoryOptions $categoryOptions,
        array $data = []
    ) {
        $this->_categoryOptions = $categoryOptions;
        parent::__construct( $context, $registry, $formFactory, $systemStore, $wysiwygConfig, $viewHelper, $data );
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm() {
        /** @var $model \Rokanthemes\Brand\Model\Brand */
        $model = $this->_coreRegistry->registry('rokanthemes_brand');

        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);
        /**
         * Checking if user have permission to save information
         */
        if($this->_isAllowedAction('Rokanthemes_Brand::brand_edit')){
            $isElementDisabled = false;
        }else {
            $isElementDisabled = true;
        }
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('brand_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Brand Information')]);


        if ($model->getId()) {
            $fieldset->addField('brand_id', 'hidden', ['name' => 'brand_id']);
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name'     => 'name',
                'label'    => __('Brand Name'),
                'title'    => __('Brand Name'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'url_key',
            'text',
            [
                'name'     => 'url_key',
                'label'    => __('URL Key'),
                'title'    => __('URL Key'),
                'note'     => __('Empty to auto create url key'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'category_id',
            'select',
            [
                'label' => __('Category'),
                'title' => __('Category'),
                'name' => 'category_id',
                'options' => $this->_categoryOptions->toOptionArray()
            ]
        );

        $fieldset->addField(
            'group_id',
            'select',
            [
                'label'    => __('Brand Group'),
                'title'    => __('Brand Group'),
                'name'     => 'group_id',
                'required' => true,
                'options'  => $this->_viewHelper->getGroupList(),
                'disabled' => $isElementDisabled
            ]
        );

        /*$fieldset->addField(
            'image',
            'image',
            [
                'name'     => 'image',
                'label'    => __('Image'),
                'title'    => __('Image'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'thumbnail',
            'image',
            [
                'name'     => 'thumbnail',
                'label'    => __('Thumbnail'),
                'title'    => __('Thumbnail'),
                'disabled' => $isElementDisabled
            ]
        );*/

        $fieldset->addField(
            'description',
            'editor',
            [
                'name'     => 'description',
                'style'    => 'height:200px;',
                'label'    => __('Description'),
                'title'    => __('Description'),
                'disabled' => $isElementDisabled,
                'config'   => $wysiwygConfig
            ]
        );


        /**
         * Check is single store mode
         */
        if (!$this->_storeManager->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'stores[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true),
                    'disabled' => $isElementDisabled
                ]
            );
            $renderer = $this->getLayout()->createBlock(
                'Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element'
            );
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'store_id',
                'hidden',
                ['name' => 'stores[]', 'value' => $this->_storeManager->getStore(true)->getId()]
            );
            $model->setStoreId($this->_storeManager->getStore(true)->getId());
        }


        $fieldset->addField(
            'position',
            'text',
            [
                'name' => 'position',
                'label' => __('Position'),
                'title' => __('Position'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Page Status'),
                'name' => 'status',
                'options' => $model->getAvailableStatuses(),
                'disabled' => $isElementDisabled
            ]
        );


        $form->setValues($model->getData());
        $this->setForm($form);

        return $this;
    }

}
