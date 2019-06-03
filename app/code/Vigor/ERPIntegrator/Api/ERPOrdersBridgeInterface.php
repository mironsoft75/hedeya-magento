<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Api;

use Magento\Sales\Model\Order;

interface ERPOrdersBridgeInterface
{
    public function getOrderById(string $id);
    public function create(Order $order);
    public function update(Order $order);

    public function createShipment(Order\Shipment $shipment);
    public function createPayment(Order\Shipment $shipment);
}
