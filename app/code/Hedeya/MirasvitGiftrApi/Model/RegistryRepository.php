<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Model;

use Hedeya\MirasvitGiftrApi\Api\Data\RegistryInterface;
use Hedeya\MirasvitGiftrApi\Api\Data\RegistryItemInterface;
use Hedeya\MirasvitGiftrApi\Api\RegistryRepositoryInterface;
use Hedeya\MirasvitGiftrApi\Api\Data\RegistrySearchResultsInterfaceFactory;
use Mirasvit\Giftr\Model\Registry;
use Mirasvit\Giftr\Model\RegistryFactory;
use Mirasvit\Giftr\Model\Item;
use Mirasvit\Giftr\Model\ItemFactory;
use Mirasvit\Giftr\Model\ResourceModel\Registry\CollectionFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;

class RegistryRepository implements RegistryRepositoryInterface
{
    protected $searchResultsFactory;
    protected $registryFactory;
    protected $registryCollectionFactory;
    protected $registryItemFactory;
    private $collectionProcessor;

    function __construct(
        RegistrySearchResultsInterfaceFactory $searchResultsFactory,
        RegistryFactory $registryFactory,
        CollectionFactory $registryCollectionFactory,
        ItemFactory $registryItemFactory,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->searchResultsFactory = $searchResultsFactory;
        $this->registryFactory = $registryFactory;
        $this->registryCollectionFactory = $registryCollectionFactory;
        $this->registryItemFactory = $registryItemFactory;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->registryCollectionFactory->create();
        $collection->addFieldToFilter('is_public', true);
        $searchResult = $this->prepareSearchResults($searchCriteria, $collection);
        
        return $searchResult;
    }

    /**
     * @inheritdoc
     */
    public function getListForCustomer($customerId, SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->registryCollectionFactory->create();
        $collection->addFieldToFilter('customer_id', $customerId);
        $searchResult = $this->prepareSearchResults($searchCriteria, $collection);
        
        return $searchResult;
    }

    /**
     * @inheritdoc
     */
    public function save($customerId, RegistryInterface $registry)
    {
        $data = $registry->toArray();
        $registryModel = $this->registryFactory->create();
        $registryUid = $data['uid'] ?? false;
        // clean array from any sensitive data
        // todo: do it better
        unset($data['id']);
        unset($data['uid']);
        unset($data['registry_id']);
        if(!$registryUid) {
            // create new registry
            $data['customer_id'] = $customerId;
            $registryModel->setData($data);
        } else {
            // update registry data
            $registryModel->loadByUid($registryUid);
            if(!$registryModel->getId() || $registryModel->getCustomerId() != $customerId)
                throw new NoSuchEntityException(
                    __('The requested gift registry %1 doesn\'t exist.', $registryUid)
                );
            $registryModel->addData($data);
        }
        $registryModel->save();
        return $registryModel;
    }

    /**
     * @inheritdoc
     */
    public function deleteRegistryById($customerId, $registryId)
    {
        $registry = $this->registryFactory->create();
        $registry->load($registryId);
        if(!$registry->getId() || $customerId != $registry->getCustomerId()) {
            throw new NoSuchEntityException(
                    __('The requested gift registry %1 doesn\'t exist.', $registryId)
                );
        }
        try {
            $registry->delete();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__("The requested gift registry couldn't be removed."));
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getItems($customerId = null, $registryUid)
    {
        $registry = $this->getRegistryByUid($registryUid);
        $isShared = $registry->getIsPublic() && $registry->getIsActive();
        $isOwner = $customerId && $customerId != $registry->getCustomerId();
        if(!$registry || (!$isOwner && !$isShared)) {
            throw new NoSuchEntityException(
                    __('The requested gift registry %1 doesn\'t exist.', $registryUid)
                );
        }
        return $this->getRegistryProductCollection($registry);
    }

    /**
     * @inheritdoc
     */
    public function saveItem($customerId, $registryUid, RegistryItemInterface $registryItem)
    {
        $data = $registryItem->toArray();
        $registry = $this->getRegistryByUid($registryUid);
        $this->validateCustomerAction($customerId, $registry->getCustomerId());
        $registryItemModel = $this->registryItemFactory->create();
        // clean array from any sensitive data
        // todo: do it better
        unset($data['id']);
        unset($data['registry_id']);
        if(!$registryItem->getId()) {
            // create new registry item
            $data['registry_id'] = $registry->getId();
            $data['registry_uid'] = $registry->getUid();
            $registryItemModel->setData($data);
        } else {
            $registryItemModel->load($registryItem->getId());
            if(!$registryItemModel->getId()) {
                throw new NoSuchEntityException(
                    __('The requested gift registry item %1 doesn\'t exist.', $registryItem->getId())
                );
            }
            $registryItemModel->addData($data);
        }
        $registryItemModel->save();
        return $registryItemModel;
    }

    /**
     * @inheritdoc
     */
    public function deleteItemById($customerId, $registryUid, $registryItemId)
    {
        $registryItem = $this->registryItemFactory->create();
        $registryItem->load($registryItemId);
        if(!$registryItem->getId()) {
            throw new NoSuchEntityException(
                    __('The requested gift registry item %1 doesn\'t exist.', $registryItemId)
                );
        }
        $registry = $registryItem->getRegistry();
        $isOwner = $customerId == $registry->getCustomerId();
        $isParentRegistry = $registryUid == $registry->getUid();
        if(!$isOwner || !$isParentRegistry) {
            throw new LocalizedException(__("Something went wrong. Please try again"));
        }
        try {
            $registryItem->delete();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__("The requested gift registry item couldn't be removed."));
        }
        return true;
    }

    private function validateCustomerAction($currentCustomerId, $customerId, bool $isShared = true): void
    {
        $isOwner = $customerId == $currentCustomerId;
        $isValid = $isOwner && $isShared;
        if(!$isValid) {
            throw new LocalizedException(__("Something went wrong. Please try again"));
        }
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

    private function getRegistryProductCollection(Registry $registry)
    {
        $products = [];
        $collection = $registry->getItemCollection();
        foreach ($collection->getItems() as $itemId => $item) {
            $product = $item->getProduct();
            if(!$product) {
                continue;
            }
            $extensionAttributes = $product->getExtensionAttributes();
            $extensionAttributes->setGiftrData(
                new \Hedeya\MirasvitGiftrApi\Model\Data\RegistryItemProduct($item)
            );
            $product->setExtensionAttributes($extensionAttributes);
            $products[] = $product;
        }
        return $products;
    }

    private function getRegistryByUid(string $registryUid): Registry
    {
        $registry = $this->registryFactory->create()->loadByUid($registryUid);
        if(!$registry) {
            throw new NoSuchEntityException(
                    __('The %1 requested gift registry doesn\'t exist.', $registryUid)
                );
        }
        return $registry;
    }

}
