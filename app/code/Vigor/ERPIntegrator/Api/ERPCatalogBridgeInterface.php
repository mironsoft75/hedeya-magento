<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Api;

use Magento\Catalog\Api\Data\ProductInterface;

interface ERPCatalogBridgeInterface
{
    /**
     * @param \DateTimeInterface $dateTime
     * @param \DateTimeInterface $endDate
     * @return array
     */
    public function getModifiedProducts(\DateTimeInterface $dateTime, \DateTimeInterface $endDate): array;
    /**
     * @param string $sku
     * @return \SimpleXMLElement
     */
    public function getItemInfoByAlu(string $sku);
}
