<?php
namespace Accept\Payments\Helper;

class Notify{
    public function __construct(
		\Magento\Sales\Model\Order $order,
		\Magento\Sales\Model\Service\InvoiceService $invoice,
		\Magento\Framework\Controller\ResultFactory $resultFactory,
		\Magento\Framework\App\ResourceConnection $resource,
		\Magento\Customer\Model\Customer $customer,
		$messageManager, $base_url, $website_id, $hmac,
		\Magento\Sales\Model\Order\CreditmemoFactory $creditmemoFactory,
		\Magento\Sales\Model\Service\CreditmemoService $creditmemoService
    )
    {
			$this->order = $order;
			$this->invoice = $invoice;
			$this->resultFactory = $resultFactory;
			$this->resource = $resource;
			$this->customer = $customer;
			$this->messageManager = $messageManager;
			$this->base_url = $base_url;
			$this->website_id = $website_id;
			$this->hmac = $hmac;
			$this->creditmemoFactory = $creditmemoFactory;
			$this->creditmemoService = $creditmemoService;
	}
	
	/**
	 * Shared function all incoming notifications pass through here.
	 * Usage: ping → pong 
	 */
    public function Pong($request_data) {
		try{
			if ($_SERVER['REQUEST_METHOD'] === "POST"){
				$json = json_decode($request_data, true);
				$obj = $json['obj'];
				$data = $json['obj'];
				$type = $json['type'];
				if ($json['type'] === 'TRANSACTION')
				{
					$data['order'] = $data['order']['id'];
					$data['is_3d_secure'] = ($data['is_3d_secure'] === true)?'true':'false';
					$data['is_auth'] = ($data['is_auth'] === true)?'true':'false';
					$data['is_capture'] = ($data['is_capture'] === true)?'true':'false';
					$data['is_refunded'] = ($data['is_refunded'] === true)?'true':'false';
					$data['is_standalone_payment'] = ($data['is_standalone_payment'] === true)?'true':'false';
					$data['is_voided'] = ($data['is_voided'] === true)?'true':'false';
					$data['success'] = ($data['success'] === true)?'true':'false';
					$data['error_occured'] = ($data['error_occured'] === true)?'true':'false';
					$data['has_parent_transaction'] = ($data['has_parent_transaction'] === true)?'true':'false';
					$data['pending'] = ($data['pending'] === true)?'true':'false';
					$data['source_data_pan'] = $data['source_data']['pan'];
					$data['source_data_type'] = $data['source_data']['type'];
					$data['source_data_sub_type'] = $data['source_data']['sub_type'];
				}
			} else if ($_SERVER['REQUEST_METHOD'] === "GET") {
				$data = $_GET;
				$type = 'TRANSACTION';
			}
			
			if ( !isset($_GET['hmac']) )
			{
				echo "INVALID REQUEST Something is missing";
				die(1);
			}

			$hash = $this->calculateHash($this->hmac, $data, $type);

			if($hash === $_REQUEST['hmac']){
				if($_SERVER['REQUEST_METHOD'] === "POST"){	
					if ($type == 'TRANSACTION') {
						$order_id = substr($json['obj']['order']['merchant_order_id'], 0, -11);
						$order = $this->order->load($order_id);
						
						if(!$order){
							die("Fatal Error: Order with the id of ($order_id) was not found!");
						}

						// ready to invoice
						$already_invoiced = false;
						foreach ($order->getInvoiceCollection() as $invoice) {
								if($invoice->getGrandTotal() == $order->getGrandTotal()){
										$already_invoiced = true;
								}
						}

						if (
								$obj['success'] === true && 
								$obj['is_voided'] === false && 
								$obj['is_refunded'] === false && 
								$obj['pending'] === false && 
								$obj['is_void'] === false && 
								$obj['is_refund'] === false &&
								$obj['error_occured'] === false &&
								$already_invoiced == false
						) {
							
							$grandTotal = $order->getGrandTotal();
							$amount_cents = $obj['amount_cents'] / 100.0;
							$currency = $order->getOrderCurrencyCode();

							if( isset($data['data']['down_payment']) ){
								$down_payment = $data['data']['down_payment'];
								$currency = $data['data']['currency'];
								$order->addStatusHistoryComment(__("Order Down payment: $down_payment $currency"))->save();
							}else{
								$order->addStatusHistoryComment( __("Order Payment Accepted: Customer Paid ($amount_cents $currency).") )
											->save();
							}

							if(isset($data['data']['receipt_url'])){
								$receipt_url = $data['data']['receipt_url'];
								$order->addStatusHistoryComment(__("<a target='_blank' href='$receipt_url'>Receipt Link</a>"))->save();
							}

							$invoice = $this->invoice->prepareInvoice($order);
							$invoice->setGrandTotal($grandTotal)
											->setBaseGrandTotal($grandTotal)
											->register()
											->pay()
											->save();
							$order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING)
										->setStatus(\Magento\Sales\Model\Order::STATE_PROCESSING)
										->save();
							
						}else if (
							$obj['success'] === true && 
							$obj['pending'] === false && 
							$obj['is_void'] === false && 
							$obj['is_refund'] === false && 
							$obj['is_refunded'] === true || $obj['is_voided'] === true
						){
							// request is a refund command ←
							$invoice_to_refund = null;
							$invoice_grand_total = 0;
							$actual_grand_total = ($obj['amount_cents'] / 100.0);
							$shipping_amount =  $order->getData()['shipping_amount'];

							foreach ($order->getInvoiceCollection() as $invoice) {
								if($invoice->getGrandTotal() == $actual_grand_total || $invoice->getGrandTotal() == $actual_grand_total + $shipping_amount){
										$invoice_to_refund = $invoice;
										$invoice_grand_total = $invoice->getGrandTotal();
								}
							}

							if(!$invoice_to_refund){
									die("couldn't find a matching invoice to refund");
							}

							if($order->getTotalRefunded() == $invoice_to_refund->getGrandTotal()){
									die("this order is already refunded.");
							}

							try {
								$creditmemo = $this->creditmemoFactory->createByOrder($order);
								$creditmemo->setInvoice($invoice_to_refund);
								$this->creditmemoService->refund($creditmemo);
								$order->setState(\Magento\Sales\Model\Order::STATE_CANCELED)
											->setStatus(\Magento\Sales\Model\Order::STATE_CANCELED)->save();
								
								if($obj['is_refunded'] === true)
								{
									$order->addStatusHistoryComment( __("Order Payment Refunded") )->save();
									echo "REFUNDED Order: ($order_id), Amount: ($invoice_grand_total)";
								}else if ($obj['is_voided'] === true)
								{
									$order->addStatusHistoryComment( __("Order Payment Voided") )->save();
									echo "VOIDED Order: ($order_id), Amount: ($invoice_grand_total)";
								}

							} catch (\Exception $error) {
									die("ERROR: ".$error->getMessage());
							}
						}else{
							$order->setState(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT)
								  ->setStatus(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT)->save();
							$order->addStatusHistoryComment( __("Order Payment Message: ".$data['data']['message']) )->save();
							$order->addStatusHistoryComment( __("Order Payment Declined.") )->save();
						}
					} else if ($type == 'TOKEN') {
						$token = $data['token'];
						$pan   = $data['masked_pan'];
						$type  = $data['card_subtype'];
						$email = $data['email'];

						$customer_id = (int) $this->customer->setWebsiteId($this->website_id)->loadByEmail($email)->getId();

						if($customer_id)
						{
							$connection = $this->resource->getConnection();
							$table = $this->resource->getTableName('Accept_Payments_Tokens');
							$search_query = "SELECT * FROM $table WHERE `card_subtype` = '$type' 
											AND `masked_pan` = '$pan' AND `customer_id` = '$customer_id'";
											
							$cards = $connection->fetchAll($search_query);
							if(!$cards){
								$query = "INSERT INTO $table (customer_id, token, masked_pan, card_subtype) 
													  Values ('$customer_id', '$token', '$pan', '$type')";
							}else{
								$query = "UPDATE $table SET `token` = '$token' WHERE `customer_id` = '$customer_id'
												AND `masked_pan` = '$pan' AND `card_subtype` = '$type'";
							}

							$connection->query($query);
						}
					}
	
					echo "OK, POST REQUEST HANDLED";
					die(0);
	
				}else if ($_SERVER['REQUEST_METHOD'] === "GET"){
					$response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
					if($data['success'] == 'true') {
						$response_url = $this->base_url . 'checkout/onepage/success';
						$this->messageManager->addSuccess( __($data['data_message']));
					} else {
						$response_url = $this->base_url . 'checkout/onepage/failure';
						$this->messageManager->addError( __($data['data_message']));
					}
					$response->setUrl($response_url);
					return $response;       
				}
			} else {
				echo "This Server is not ready to handle your request right now.";
				die(1);
			}	
		}catch(\Exception $e){
			\var_dump($e);
			echo "====================================";
			echo $e->getMessage();
			echo "====================================";
			die(1);
		}
	}

    public function calculateHash($key, $data, $type) {
		$str = '';
		switch($type) {
			case 'TRANSACTION':
				$str =
					$data['amount_cents'].
					$data['created_at'].
					$data['currency'].
					$data['error_occured'].
					$data['has_parent_transaction'].
					$data['id'].
					$data['integration_id'].
					$data['is_3d_secure'].
					$data['is_auth'].
					$data['is_capture'].
					$data['is_refunded'].
					$data['is_standalone_payment'].
					$data['is_voided'].
					$data['order'].
					$data['owner'].
					$data['pending'].
					$data['source_data_pan'].
					$data['source_data_sub_type'].
					$data['source_data_type'].
					$data['success'];
				break;
			case 'TOKEN':
				$str =
					$data['card_subtype'].
					$data['created_at'].
					$data['email'].
					$data['id'].
					$data['masked_pan'].
					$data['merchant_id'].
					$data['order_id'].
					$data['token'];
				break;
			case 'DELIVERY_STATUS':
				$str =
					$data['created_at'].
					$data['extra_description'].
					$data['gps_lat'].
					$data['gps_long'].
					$data['id'].
					$data['merchant'].
					$data['order'].
					$data['status'];
				break;
		}
		$hash = hash_hmac('sha512',$str, $key);
		return $hash;
	}
}
