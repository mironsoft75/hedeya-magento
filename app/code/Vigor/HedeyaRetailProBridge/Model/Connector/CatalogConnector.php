<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\HedeyaRetailProBridge\Model\Connector;

use Vigor\HedeyaRetailProBridge\Api\ConnectorInterface;

/**
 * Class CatalogConnector
 * @package Vigor\HedeyaRetailProBridge\Model\Connector
 */
class CatalogConnector implements ConnectorInterface
{
    /**
     *
     */
    public const MODIFIED_PRODUCTS_URI = 'http://197.50.45.113:8090/wsdl/IRPWebServices';
    /**
     *
     */
    private const TIMEOUT_SECONDS = 1800;
    /**
     * Http Client Factory
     *
     * @var \Magento\Framework\HTTP\ZendClientFactory
     */
    protected $soapClient;

    /**
     * CatalogConnector constructor.
     * @throws  \SoapFault
     */
    public function __construct()
    {
        $this->soapClient = new \SoapClient(self::MODIFIED_PRODUCTS_URI, array(
            'debug'              => true,
            'trace'              => true,
            'exceptions'         => true,
            'keep_alive'         => false,
            'connection_timeout' => self::TIMEOUT_SECONDS,
            'cache_wsdl'         => WSDL_CACHE_NONE,
            'compression'        => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
        ));
    }

    /**
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @return mixed
     */
    public function getModifiedProducts(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
        return $this->soapClient->__soapCall(
            'GetModifidItemsCompQtysInRange',
            ['AdFromDate' => $startDate->format('Y/m/d'), 'AdToDate' => $endDate->format('Y/m/d')]
        );
    }
}
