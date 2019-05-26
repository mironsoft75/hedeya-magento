<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Service;

interface CatalogInterface
{
    /**
     * @param  int    $categoryId
     * @return \Hedeya\MobileApi\Api\Data\Catalog\FilterInterface[]
     */
    public function getFiltersList(int $categoryId);

    /**
     * @param  int    $categoryId
     * @return \Hedeya\MobileApi\Api\Data\Catalog\SorterInterface
     */
    public function getSortersList(int $categoryId);

    /**
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getCatalogListBestseller();

    /**
     * @param int|null $rootCategoryId
     * @param int|null $depth
     * @throws \Magento\Framework\Exception\NoSuchEntityException If ID is not found
     * @return \Hedeya\MobileApi\Api\Data\Catalog\CategoryTreeItemInterface[]
     */
    public function getCatalogCategoryTree($rootCategoryId = null, $depth = null);

    /**
     * @param  string    $queryText
     * @return \Hedeya\MobileApi\Api\Data\SearchAutocompleteItemInterface[]
     */
    public function getSearchSuggestions($queryText);

    /**
     * @param  string    $name
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function searchCatalogByBrand($name);
}
