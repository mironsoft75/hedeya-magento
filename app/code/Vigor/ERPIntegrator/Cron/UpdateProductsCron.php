<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Cron;

use Psr\Log\LoggerInterface;
use Vigor\ERPIntegrator\Api\ERPCronInterface;
use Vigor\ERPIntegrator\Helper\SyncDate;
use Vigor\ERPIntegrator\Model\Publisher\CatalogPublisher;

class UpdateProductsCron implements ERPCronInterface
{
    protected $logger;
    protected $catalogPublisher;
    protected $syncDateHelper;

    public function __construct(LoggerInterface $logger, CatalogPublisher $catalogPublisher, SyncDate $syncDateHelper)
    {
        $this->catalogPublisher = $catalogPublisher;
        $this->logger = $logger;
        $this->syncDateHelper = $syncDateHelper;
    }

    public function execute()
    {
        try {
            $data = $this->syncDateHelper->readSyncData();
        } catch (\Exception $e) {
            $currentYear = new \DateTime();
            $currentYear->setDate($currentYear->format('Y'), 1, 1);
            $data = [
                $currentYear->format('Y-m-d')
            ];
        }

        $dateTime = new \DateTime($data[0]);

        $this->catalogPublisher->addProductsToQueue($dateTime);
    }
}
