<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Model\Service; 
 
use Magento\Framework\DataObject;

class Catalog implements \Hedeya\MobileApi\Api\Service\CatalogInterface
{
    const CATALOG_TYPE = 'category'; // [search, category]

    protected $catalogHelper;
    protected $helper;
    protected $catalogCollectionHelper;

    public function __construct(
        \Hedeya\MobileApi\Helper\Catalog $catalogHelper,
        \Hedeya\MobileApi\Helper\CatalogData $helper,
        \Hedeya\MobileApi\Helper\CatalogCollection $catalogCollectionHelper
    ) {
        $this->catalogHelper = $catalogHelper;
        $this->helper = $helper;
        $this->catalogCollectionHelper = $catalogCollectionHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFiltersList(int $categoryId)
    {
        return $this->helper->getFiltersByCategoryId($categoryId);
    }

    /**
     * {@inheritdoc}
     */
    public function getSortersList(int $categoryId)
    {
        return $this->helper->getSortersByCategoryId($categoryId);
    }

    /**
     * {@inheritdoc}
     */
    public function getCatalogListBestseller()
    {
        return $this->catalogCollectionHelper->getProductBestsellers(null, 12);
    }

    /**
     * {@inheritdoc}
     */
    public function getCatalogCategoryTree($rootCategoryId = null, $depth = null)
    {
        return $this->catalogCollectionHelper->getCategoryTreeList($rootCategoryId, $depth);
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchSuggestions($queryText)
    {
        return $this->catalogHelper->getSearchSuggestionsByQuery($queryText);
    }
    
    /**
     * {@inheritdoc}
     */
    public function searchCatalogByBrand($name)
    {
        return $this->catalogCollectionHelper->getProductsByCategoryName($name);
    }
    




}
