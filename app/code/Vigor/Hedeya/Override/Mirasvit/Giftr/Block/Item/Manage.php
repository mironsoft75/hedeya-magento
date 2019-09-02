<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\Hedeya\Override\Mirasvit\Giftr\Block\Item;

class Manage extends \Mirasvit\Giftr\Block\Item\Manage
{
    public function getProductImage($item, $type, $itemOptions)
    {
        return parent::getProductImage($item, $type, $itemOptions)
            ->setTemplate('Magento_Catalog::product/image_with_borders_no_lazy.phtml');
    }
}