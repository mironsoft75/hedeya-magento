<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Api;

use Magento\Customer\Api\Data\CustomerInterface;

interface ERPCustomersBridgeInterface
{
    public function getCustomerByERPId(string $id);
    public function getCustomerByPhone(string $phone);
    public function getNewCustomerId(array $params);
    public function update(CustomerInterface $customer);
}
