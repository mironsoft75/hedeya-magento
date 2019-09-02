<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\HedeyaRetailProBridge\Model\Bridge;

use Vigor\ERPIntegrator\Api\ERPCatalogBridgeInterface;
use Vigor\HedeyaRetailProBridge\Model\Connector\CatalogConnector;

/**
 * Class CatalogBridge
 * @package Vigor\HedeyaRetailProBridge\Model\Bridge
 */
class CatalogBridge implements ERPCatalogBridgeInterface
{
    /**
     * @var CatalogConnector
     */
    protected $catalogConnector;
    /**
     * @var \Vigor\HedeyaRetailProBridge\Model\Mapper\ProductMapper
     */
    protected $productMapper;
    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $jsonSerializer;

    /**
     * CatalogBridge constructor.
     * @param CatalogConnector $catalogConnector
     * @param \Vigor\HedeyaRetailProBridge\Model\Mapper\ProductMapper $productMapper
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
     */
    public function __construct(
        CatalogConnector $catalogConnector,
        \Vigor\HedeyaRetailProBridge\Model\Mapper\ProductMapper $productMapper,
        \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
    ) {
        $this->catalogConnector = $catalogConnector;
        $this->productMapper = $productMapper;
        $this->jsonSerializer = $jsonSerializer;
    }


    /**
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @return array
     */
    public function getModifiedProducts(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
    {
        $response = $this->catalogConnector->getModifiedProducts($startDate, $endDate);

        return $this->productMapper->map($response);
    }
}
