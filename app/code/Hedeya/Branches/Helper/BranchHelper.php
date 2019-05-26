<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Helper;

class BranchHelper extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $modelFactory;
    protected $repository;
    protected $csvHelper;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Hedeya\Branches\Model\BranchFactory $modelFactory,
        \Hedeya\Branches\Api\BranchRepositoryInterface $repository,
        \Hedeya\Branches\Helper\CsvHandler $csvHelper
    ){
        $this->modelFactory = $modelFactory;
        $this->repository = $repository;
        $this->csvHelper = $csvHelper;
        parent::__construct($context);
    }

    public function exportCsv(bool $download = false)
    {
        if($branches = $this->repository->getList()) {
            $file = $this->convertCollectionItemsToCsv($branches);
            if($download) {
                $file->output("branches-" . md5(time()) . '.csv');
            }
            return $file;
        }

    }

    public function importCsv($file = null)
    {
        // validate file existence
        if(!$file)
            throw new \Exception("Nothing to import", 1);

        // validate file extension
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        if("csv" !== $fileExt)
            throw new \Exception("Invalid file type", 1);

        $total = $processed = 0;
        $records = $this->csvHelper->read($file);
        if(!empty($records)) {
            $this->repository->purgeAll();
            $total = count($records);
            foreach ($records as $data) {
                unset($data['branch_id']);
                $entity = $this->modelFactory->create();
                $entity->setData($data);
                $entity->save();
                if($entity->getId()) {
                    $processed++;
                }
            }
        }
        return [$total, $processed];
    }

    protected function convertCollectionItemsToCsv($items)
    {
        $header = $contents = [];
        // $items = $collection->getItems();
        array_walk($items, function($item) use (&$header, &$contents) {
            $itemData = $item->toArray();
            // @todo: find better solution than nested loops. (maybe flatten arrays function)
            array_walk($itemData, function($value, $key) use (&$itemData) {
                // implode arrays to prevent last implode failure
                if(is_array($value))
                    $itemData[$key] = implode(',', $value);
            });
            if(empty($header)) {
                $header = array_keys($itemData);
            }
            $contents[] = array_values($itemData);
        });
        $csv = $this->csvHelper->write($header, $contents);
        return $csv;
    }
}
