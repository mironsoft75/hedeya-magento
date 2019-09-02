<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data;

interface SearchAutocompleteItemInterface extends \Magento\Search\Model\Autocomplete\ItemInterface
{
    /**
     * @return string
     */
    public function getNumResults();
}
