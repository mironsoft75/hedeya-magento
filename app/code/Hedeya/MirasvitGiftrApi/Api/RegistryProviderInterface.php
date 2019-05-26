<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface RegistryProviderInterface
{
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Hedeya\MirasvitGiftrApi\Api\Data\RegistrySearchResultsInterface
     */
     // * @param string[] $searchParams
    public function search(SearchCriteriaInterface $searchCriteria);
}