<?php
namespace Accept\Payments\Controller\Callback;

use Accept\Payments\Helper\Notify;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;

class Valu extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface, HttpGetActionInterface, CsrfAwareActionInterface {

    public function __construct(
		\Magento\Framework\App\Action\Context $context, 
		\Magento\Sales\Model\Order $order,
		\Magento\Sales\Model\Service\InvoiceService $invoice,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\App\ResourceConnection $resource,
		\Magento\Customer\Model\Customer $customer,
		\Accept\Payments\Model\Valu $valu,
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
			$this->valu = $valu;
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
				$this->valu->getConfigData('hmac_secret'),
				$this->creditmemoFactory,
				$this->creditmemoService
			);
			return $ping->Pong($this->getRequest()->getContent());
			
		}catch (\Exception $e){
			\var_dump($e);
			die(1);
		}



	}

    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}