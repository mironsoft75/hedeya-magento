<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\Brands\Block\Widget;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\Template;

class Carousel extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    protected $_template = 'widget/brands_carousel.phtml';
    private $_categoryCollectionFactory;

    public function __construct(Template\Context $context, CollectionFactory $collectionFactory, array $data = [])
    {
        parent::__construct($context, $data);
        $this->_categoryCollectionFactory = $collectionFactory;
    }


    public function getBrandsCollection()
    {
        $categoriesCollection = $this->_categoryCollectionFactory->create();

        $categoriesCollection
            ->addAttributeToSelect('brand_logo')
            ->addAttributeToSelect('brand_show_in_home')
            ->addFieldToFilter('brand_show_in_home', array('eq' => true));

        return $categoriesCollection;
    }
}
