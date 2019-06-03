<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Api;

use Magento\InventoryApi\Api\Data\SourceInterface;

interface ERPSourcesBridgeInterface
{
    /**
     * @return SourceInterface[]
     */
    public function getSources(): array;
}
