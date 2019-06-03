<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Console\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vigor\ERPIntegrator\Model\Publisher\CatalogPublisher;

class UpdateProductsCommand extends \Symfony\Component\Console\Command\Command
{
    const COMMAND_ERP_CATALOG_UPDATE_PRODUCTS = 'erp:catalog:update-products';
    const DATETIME_ARGUMENT = 'datetime';

    protected $catalogPublisher;
    protected $logger;

    public function __construct(LoggerInterface $logger, CatalogPublisher $catalogPublisher)
    {
        $this->catalogPublisher = $catalogPublisher;
        $this->logger = $logger;
        parent::__construct();
    }


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_ERP_CATALOG_UPDATE_PRODUCTS)
            ->setDescription('Update products using the specified date')
            ->setDefinition([
                new InputArgument(
                    self::DATETIME_ARGUMENT,
                    InputArgument::OPTIONAL,
                    'DateTime'
                )
            ]);
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dateTimeString = $input->getArgument(self::DATETIME_ARGUMENT);

        $dateTime = new \DateTime($dateTimeString);

        $this->catalogPublisher->addProductsToQueue($dateTime);
    }
}
