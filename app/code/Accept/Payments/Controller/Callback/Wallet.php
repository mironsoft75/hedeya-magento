<?php
namespace Accept\Payments\Controller\Callback;

use Accept\Payments\Helper\Notify;

class Wallet extends \Magento\Framework\App\Action\Action {

    public function __construct(
		\Magento\Framework\App\Action\Context $context, 
		\Magento\Sales\Model\Order $order,
		\Magento\Sales\Model\Service\InvoiceService $invoice,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\App\ResourceConnection $resource,
		\Magento\Customer\Model\Customer $customer,
		\Accept\Payments\Model\Wallet $wallet,
		\Magento\Sales\Model\Order\CreditmemoFactory $creditmemoFactory,
		\Magento\Sales\Model\Service\CreditmemoService $creditmemoService
    )
    {
			parent::__construct($context);
			$this->context = $context;
			$this->order = $order;
			$this->invoice = $invoice;
			$this->resultFactory = $context->getResultFactory();
			$this->base_url = $storeManager->getStore()->getBaseUrl();
			$this->website_id = $storeManager->getStore()->getWebsiteId();
			$this->resource = $resource;
			$this->customer = $customer;
			$this->wallet = $wallet;
			$this->creditmemoFactory = $creditmemoFactory;
			$this->creditmemoService = $creditmemoService;
    }

    public function execute() {
		try{

			$ping = new Notify(
				$this->order,
				$this->invoice,
				$this->resultFactory,
				$this->resource,
				$this->customer,
				$this->messageManager,
				$this->base_url,
				$this->website_id,
				$this->wallet->getConfigData('hmac_secret'),
				$this->creditmemoFactory,
				$this->creditmemoService
			);
			return $ping->Pong($this->getRequest()->getContent());
			
		}catch (\Exception $e){
			\var_dump($e);
			die(1);
		}

	}
}