<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Controller\Adminhtml\Index;

class Import extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Hedeya_Branches::branches';

    protected $helper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Hedeya\Branches\Helper\BranchHelper $helper
    ){
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        // attempt to upload files
        if($file = $this->getRequest()->getFiles('import_branches_file')) {
            try {
                list($total, $processed) = $this->helper->importCsv($file);
                $this->messageManager->addSuccess(__('Imported %1 out of %2 records', $total, $processed));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        $this->messageManager->addNotice(__("Make sure you backup your branches by using export option before starting import."));

        // render actual page
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Magento_Backend::content');
        $resultPage->addBreadcrumb('Branches', 'Branches');
        $resultPage->getConfig()->getTitle()->prepend(__('Import Branches'));
        return $resultPage;
    }
}
