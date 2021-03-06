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



namespace Mirasvit\Giftr\Controller\Adminhtml\Section;

use Magento\Framework\Controller\ResultFactory;
use \Magento\Framework\Exception\LocalizedException;

class Save extends \Mirasvit\Giftr\Controller\Adminhtml\Section
{
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if ($data = $this->getRequest()->getParams()) {
            $section = $this->_initSection();
            if (!isset($data['field_ids'])) {
                $data['field_ids'] = [];
            }

            $section->addData($data);

            try {
                foreach ($section->getForbiddenFieldNames() as $fieldName) {
                    if ($section->dataHasChangedFor($fieldName)) {
                        throw new LocalizedException(
                            __('The field: "%1" is system and cannot be changed.', $fieldName)
                        );
                    }
                }

                $section->save();

                $this->messageManager->addSuccess(__('Registry Form Section was successfully saved'));
                $this->backendSession->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [
                        'id' => $section->getId(), 'store' => $section->getStoreId()
                    ]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $this->backendSession->setFormData($data);

                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        }
        $this->messageManager->addError(__('Unable to find Registry Form Section to save'));

        return $resultRedirect->setPath('*/*/');
    }
}
