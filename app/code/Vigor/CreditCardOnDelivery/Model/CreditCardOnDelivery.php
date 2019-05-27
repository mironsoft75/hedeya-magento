<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\CreditCardOnDelivery\Model;

class CreditCardOnDelivery extends \Magento\Payment\Model\Method\AbstractMethod
{
    protected $_code = 'creditcardondelivery';
    protected $_isOffline = true;
}
