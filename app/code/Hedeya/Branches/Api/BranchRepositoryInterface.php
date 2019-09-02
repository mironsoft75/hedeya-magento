<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Api;

interface BranchRepositoryInterface
{
    /**
     * @return \Hedeya\Branches\Api\Data\BranchInterface[]
     */
    public function getList();

    /**
     * @param string[] $data
     * @return \Hedeya\Branches\Api\Data\BranchInterface
     */
    public function save(array $data);

}
