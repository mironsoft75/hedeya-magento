<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\Hedeya\Override\Amasty\Xsearch\Block\Search;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\App\Response\RedirectInterface;

class Product extends \Amasty\Xsearch\Block\Search\Product
{
    public function _construct()
    {
        parent::_construct();
        $this->_template = 'Amasty_Xsearch::search/product.phtml';
    }

    public function getImage($product, $imageId, $attributes = [])
    {
        return parent::getImage($product, $imageId, $attributes)
            ->setTemplate('Magento_Catalog::product/image_with_borders_no_lazy.phtml');
    }
}