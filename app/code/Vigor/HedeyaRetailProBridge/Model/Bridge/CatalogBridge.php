<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\HedeyaRetailProBridge\Model\Bridge;

use Vigor\ERPIntegrator\Api\ERPCatalogBridgeInterface;
use Vigor\HedeyaRetailProBridge\Model\Connector\CatalogConnector;

class CatalogBridge implements ERPCatalogBridgeInterface
{
    protected $catalogConnector;
    protected $productMapper;
    protected $jsonSerializer;

    public function __construct(
        CatalogConnector $catalogConnector,
        \Vigor\HedeyaRetailProBridge\Model\Mapper\ProductMapper $productMapper,
        \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
    ) {
        $this->catalogConnector = $catalogConnector;
        $this->productMapper = $productMapper;
        $this->jsonSerializer = $jsonSerializer;
    }


    public function getModifiedProducts(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
    {
        $response = $this->catalogConnector->getModifiedProducts($startDate, $endDate);

        return $this->productMapper->map($response);
    }
}
