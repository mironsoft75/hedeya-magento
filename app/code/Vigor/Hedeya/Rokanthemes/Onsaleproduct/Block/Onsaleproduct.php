<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\Hedeya\Rokanthemes\Onsaleproduct\Block;

class Onsaleproduct extends \Rokanthemes\Onsaleproduct\Block\Onsaleproduct
{
    public function getProducts()
    {
        $products = parent::getProducts();
        $products->getSelect()->where(
            'stock_status_index.stock_status = ?',
            \Magento\CatalogInventory\Model\Stock\Status::STATUS_IN_STOCK
        );

        return $products;
    }
}