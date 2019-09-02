<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Model;

use Hedeya\MirasvitGiftrApi\Api\RegistryProviderInterface;
use Mirasvit\Giftr\Model\Service\RegistrySearchService;
use Hedeya\MirasvitGiftrApi\Api\Data\RegistrySearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class RegistryProvider implements RegistryProviderInterface
{
    protected $registrySearch;
    protected $searchResultsFactory;
    private $collectionProcessor;

    function __construct(
        RegistrySearchService $registrySearch,
        RegistrySearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->registrySearch = $registrySearch;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * @inheritdoc
     */
    // public function search($searchParams)
    public function search(SearchCriteriaInterface $searchCriteria)
    {
        $searchParams = $this->getSearchParams($searchCriteria);
        $searchCriteria->setFilterGroups();
        $collection = $this->registrySearch->search($searchParams);
        $searchResult = $this->prepareSearchResults($searchCriteria, $collection);
        return $searchResult;
    }

    private function getSearchParams($searchCriteria)
    {
        $searchParams = [];
        $registryId = $name = $eventAt = $location = null;
        $acceptedSearchParams = ['registry_id', 'name', 'event_at', 'location'];
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $field = $filter->getField();
                if(in_array($field, $acceptedSearchParams)) {
                    $searchParams[$field] = trim($filter->getValue());
                    $$field = trim($filter->getValue());
                }
            }
        }
        $searchParams = [
            'registry_id' => $registryId,
            'name' => $name,
            'event_at' => $eventAt,
            'location' => $location,
        ];
        return $searchParams;
    }

    private function prepareSearchResults($searchCriteria, $collection)
    {
        $this->collectionProcessor->process($searchCriteria, $collection);
        $collection->load();
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }

    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Magento\Catalog\Model\Api\SearchCriteria\ProductCollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }

}