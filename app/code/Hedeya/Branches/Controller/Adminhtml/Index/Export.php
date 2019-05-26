<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Controller\Adminhtml\Index;

class Export extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Hedeya_Branches::branches';

    protected $helper;

    public function __construct(
        \Hedeya\Branches\Helper\BranchHelper $helper,
        \Magento\Backend\App\Action\Context $context
    ){
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $this->helper->exportCsv(true);
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_RAW);
    }

}
