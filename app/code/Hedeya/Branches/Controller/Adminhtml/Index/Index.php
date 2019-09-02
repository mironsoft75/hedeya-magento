<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Hedeya_Branches::branches';

    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Magento_Backend::content');
        $resultPage->addBreadcrumb('Branches', 'Branches');
        $resultPage->getConfig()->getTitle()->prepend(__('Hedeya Branches'));
        return $resultPage;
    }
}
