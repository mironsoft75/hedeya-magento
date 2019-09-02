<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Api\Data;

interface RegistrySearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Hedeya\MirasvitGiftrApi\Api\Data\RegistryInterface[]
     */
    public function getItems();

    /**
     * @param \Hedeya\MirasvitGiftrApi\Api\Data\RegistryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
