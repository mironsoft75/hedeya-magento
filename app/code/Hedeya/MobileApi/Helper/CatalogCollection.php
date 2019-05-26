<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Helper;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ResourceConnection\SourceProviderInterface;
use Magento\Framework\DB\Select;

class CatalogCollection extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $storeManager;
    protected $productCollectionFactory;
    protected $searchResultsFactory;
    protected $categoryFactory;
    protected $categoryCollectionFactory;
    protected $categoryRepository;
    protected $categoryManagement;
    protected $catalogConfig;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Api\CategoryManagementInterface $categoryManagement,
        \Magento\Catalog\Model\Config $catalogConfig
    ){
        $this->storeManager = $storeManager;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->categoryFactory = $categoryFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->categoryRepository = $categoryRepository;
        $this->categoryManagement = $categoryManagement;
        $this->catalogConfig = $catalogConfig;
        parent::__construct($context);
    }

    public function getBestsellerProducts($fromDate = null, $toDate = null, int $count = null)
    {
        $collection = $this->productCollectionFactory->create();
        $this->prepareCollectionAttributes($collection);

        $collection->getSelect()
                   ->joinINNER(
                        ['aggregation' => $collection->getResource()->getTable('sales_bestsellers_aggregated_monthly')], 
                        "e.entity_id = aggregation.product_id AND aggregation.period BETWEEN '{$fromDate}' AND '{$toDate}'",
                        ['SUM(aggregation.qty_ordered) AS sold_quantity']
                    )
                    // exclude out of stock products
                    ->join(
                        ['i' => 'cataloginventory_stock_item'],
                        'e.entity_id = i.product_id AND i.is_in_stock <> 0'
                    )
                    ->group('e.entity_id')
                    ->order(['sold_quantity DESC', 'e.created_at']);
        
        if($count) {
            $collection->getSelect()->limit($count);
        }

        return $collection;
    }

    public function getProductsByCategoryName(string $categoryName = '')
    {
        $categoryCollection = $this->categoryCollectionFactory->create()
            ->addAttributeToFilter('name', ['like' => "%{$categoryName}%"]);

        $categoryIds = $categoryCollection->getAllIds();

        $productCollection = $this->productCollectionFactory->create()
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('image')
            ->addAttributeToFilter('price', array('gt' => 0))
            ->addAttributeToFilter('is_saleable', 1, 'left')
            ->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
            ->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
            ->addAttributeToSort('created_at', 'desc')
            ->addCategoriesFilter(['in' => $categoryIds]);

        $searchResult = $this->createCollectionSearchResults($productCollection);

        return $searchResult;
    }

    public function getProductBestsellers(int $categoryId = null, int $limit = null)
    {
        $collection = $this->productCollectionFactory->create();
        $connection = $collection->getResource()->getConnection();
        $collection->clear()
            ->getSelect()
            ->reset(Select::WHERE)
            ->reset(Select::ORDER)
            ->reset(Select::LIMIT_COUNT)
            ->reset(Select::LIMIT_OFFSET)
            ->reset(Select::GROUP)
            ->reset(Select::COLUMNS)
            ->reset('from');
        $collection->getSelect()->join(['e' => $connection->getTableName('catalog_product_entity')],'');
        $collection->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('image')
            ->addAttributeToSelect('small_image')
            ->addAttributeToSelect('thumbnail')
            ->addAttributeToSelect($this->catalogConfig->getProductAttributes())
            ->addUrlRewrite()
            ->addAttributeToFilter('is_saleable', 1, 'left');
        
        if($categoryId) {
            // $category = $categoryId;
            // $collection->addCategoryFilter($category);
        }

        $collection->getSelect()
            ->joinLeft(['soi' => $connection->getTableName('sales_order_item')], 'soi.product_id = e.entity_id', ['SUM(soi.qty_ordered) AS ordered_qty'])
            ->join(['order' => $connection->getTableName('sales_order')], "order.entity_id = soi.order_id",['order.state'])
            ->where("order.state <> 'canceled' and soi.parent_item_id IS NULL AND soi.product_id IS NOT NULL")
            ->group('soi.product_id')
            ->order('ordered_qty DESC')
            ->limit($limit);

        $collection->addCategoryIds();
        $searchResult = $this->createCollectionSearchResults($collection);
        return $searchResult;
    }

    public function getCategoryTreeList($rootCategoryId = null, $depth = null)
    {
        $tree = [];
        if($rootCategoryId) {
            $category = $this->categoryFactory->create()->load($rootCategoryId);
        }
        else {
            $category = $this->getRootCategory();
        }
        if($category) {
            $tree[] = new \Hedeya\MobileApi\Model\Data\CategoryTreeItem($category, $depth);
        }
        return $tree;
    }

    protected function getRootCategory()
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addFilter('level', ['eq' => 1]);
                   // ->addAttributeToSelect('*');
        return $collection->getFirstItem();
    }

    protected function createCollectionSearchResults(SourceProviderInterface $collection)
    {
        $searchResult = $this->searchResultsFactory->create();
        // // $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());        
        return $searchResult;
    }

    /**
     * add required attributes to collection select
     * @param  [type] &$collection [description]
     * @return [type]              [description]
     */
    protected function prepareCollectionAttributes(&$collection)
    {
        $collection->addPriceData()
           ->addAttributeToSelect('name')
           ->addAttributeToSelect('image')
           ->addAttributeToSelect('small_image')
           ->addAttributeToSelect('thumbnail')
           ->addAttributeToSelect($this->catalogConfig->getProductAttributes())
           ->addUrlRewrite()
           ->addAttributeToFilter('is_saleable', 1, 'left');
    }


}
