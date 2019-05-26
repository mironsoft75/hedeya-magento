<?php
/**
 * Copyright © Hedeya, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Hedeya\GraphQL\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\CatalogGraphQl\Model\Resolver\Products\Query\Filter;
use Magento\CatalogGraphQl\Model\Resolver\Products\Query\Search;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Catalog\Model\Layer\Resolver;
use Hedeya\MobileApi\Helper\CatalogCollection;


use Magento\Framework\GraphQl\Exception\GraphQlInputException;


class Bestsellers implements ResolverInterface
{
    private $catalogCollectionHelper;

    /**
     * @param CatalogCollection $catalogCollectionHelper
     */
    public function __construct(
        CatalogCollection $catalogCollectionHelper

    ) {
        $this->catalogCollectionHelper = $catalogCollectionHelper;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $period = $args['period'] ?? 'monthly';
        $pageSize = $args['pageSize'] ?? 10;
        $currentPage = $args['currentPage'] ?? 1;

        $date = new \Zend_Date();
        // $from = $date->subMonth(12)->getDate()->get('Y-MM-dd');
        $to = $date->setDay(1)->getDate()->get('Y-MM-dd');
        $from = $date->subMonth(75)->getDate()->get('Y-MM-dd');

        $collection = $this->catalogCollectionHelper->getBestsellerProducts($from, $to, $pageSize);
        $collection->setPageSize($pageSize)->setCurPage($currentPage);

        //possible division by 0
        if ($collection->getPageSize()) {
            $maxPages = ceil($collection->getSize() / $collection->getPageSize());
        } else {
            $maxPages = 0;
        }

        $data = [
            'total_count' => $collection->getSize(),
            'items' => $collection->getItems(),
            'page_info' => [
                'page_size' => $collection->getPageSize(),
                'current_page' => $collection->getCurPage(),
                'total_pages' => $maxPages
            ],
            'layer_type' => Resolver::CATALOG_LAYER_SEARCH
        ];

        return $data;
    }
}
