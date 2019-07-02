<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\UrlRewriteAddSku\Model\Magento\CatalogUrlRewrite;

class ProductUrlPathGenerator extends \Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator
{
    protected function prepareProductUrlKey(\Magento\Catalog\Model\Product $product)
    {
        $urlKey = $product->getUrlKey();
        return $product->formatUrlKey($urlKey === '' || $urlKey === null ? $product->getName().'-'.$product->getSku() : $urlKey);
    }

}