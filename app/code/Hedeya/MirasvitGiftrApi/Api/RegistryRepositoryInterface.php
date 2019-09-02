<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Api;

use Hedeya\MirasvitGiftrApi\Api\Data\RegistryInterface;
use Hedeya\MirasvitGiftrApi\Api\Data\RegistryItemInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface RegistryRepositoryInterface
{
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Hedeya\MirasvitGiftrApi\Api\Data\RegistrySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param int|null $customerId
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Hedeya\MirasvitGiftrApi\Api\Data\RegistrySearchResultsInterface
     */
    public function getListForCustomer($customerId, SearchCriteriaInterface $searchCriteria);

    /**
     * @param int $customerId
     * @param \Hedeya\MirasvitGiftrApi\Api\Data\RegistryInterface $registry
     * @return \Hedeya\MirasvitGiftrApi\Api\Data\RegistryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save($customerId, RegistryInterface $registry);

    /**
     * @param int $customerId
     * @param int $registryId
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function deleteRegistryById($customerId, $registryId);

    /**
     * @param int|null $customerId
     * @param  string $registryUid
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getItems($customerId = null, $registryUid);

    /**
     * @param int $customerId
     * @param  string $registryUid
     * @param \Hedeya\MirasvitGiftrApi\Api\Data\RegistryItemInterface $registryItem
     * @return \Hedeya\MirasvitGiftrApi\Api\Data\RegistryItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function saveItem($customerId, $registryUid, RegistryItemInterface $registryItem);

    /**
     * @param int $customerId
     * @param  string $registryUid
     * @param  int $registryItemId [description]
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteItemById($customerId, $registryUid, $registryItemId);




}
