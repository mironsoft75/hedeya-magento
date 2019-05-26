<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Model;

use Hedeya\Branches\Api\BranchRepositoryInterface;
use Hedeya\Branches\Api\Data\BranchInterface;

class BranchRepository implements BranchRepositoryInterface
{
    public function __construct(
        \Hedeya\Branches\Model\BranchFactory $modelFactory,
        \Hedeya\Branches\Model\ResourceModel\Branch\CollectionFactory $collectionFactory
    ) {
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
    }

    public function getList()
    {
        return $this->collectionFactory->create()->getItems();
    }

    public function save(array $data): BranchInterface
    {
        $model = $this->createBranchModel($data);
        $model->save();
        return $model;
    }

    public function purgeAll(): bool
    {
        $model = $this->createBranchModel();
        $connection = $model->getResource()->getConnection();
        $tableName = $model->getResource()->getMainTable();
        $connection->truncateTable($tableName);
        return true;
    }

    protected function createBranchModel(array $data = []): BranchInterface
    {
        $model = $this->modelFactory->create();
        if($data) {
            $model->setData($data);
        }
        return $model;
    }


}
