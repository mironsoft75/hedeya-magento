<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Model\Service; 
 
use Magento\Framework\DataObject;

class Home implements \Hedeya\MobileApi\Api\Service\HomeInterface
{
    const ATTR_IS_HOME = "mapi_is_home";
    const ATTR_CATEGORY_ORDER = "mapi_category_order";

    protected $categoryCollectionFactory;
    protected $bannersRepository;
    protected $catalogCollectionHelper;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magepotato\Banners\Api\BannersRepositoryInterface $bannersRepository,
        \Hedeya\MobileApi\Helper\CatalogCollection $catalogCollectionHelper
    ){
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->bannersRepository = $bannersRepository;
        $this->catalogCollectionHelper = $catalogCollectionHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return new DataObject([
            'slider_banners' =>  $this->getHomeListedBanners(),
            'categories' =>  $this->getHomeCategoryCollection()->getItems(),
            'bestsellers' =>  $this->getHomeBestsellersCollection()->getItems(),
        ]);
    }

    protected function getHomeListedBanners()
    {
        # @todo: dynamic area identifier
        return $this->bannersRepository->getByAreaIdentifier('mobile_home');
        return  [
            'http://via.placeholder.com/430x230/fff/ed4696/?text=Banner%2001',
            'http://via.placeholder.com/430x230/ed4696/fff/?text=Banner%2002',
            'http://via.placeholder.com/430x230/fff/ed4696/?text=Banner%2003',
        ];
    }

    protected function getHomeCategoryCollection()
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addFieldToFilter(self::ATTR_IS_HOME, 1)
                   ->addAttributeToSelect('*')
                   ->setOrder(self::ATTR_CATEGORY_ORDER, 'asc');

        return $collection;
    }

    protected function getHomeBestsellersCollection()
    {
        $date = new \Zend_Date();
        // $from = $date->subMonth(12)->getDate()->get('Y-MM-dd');
        $to = $date->setDay(1)->getDate()->get('Y-MM-dd');
        $from = $date->subMonth(75)->getDate()->get('Y-MM-dd');
        $count = 12;

        return $this->catalogCollectionHelper->getBestsellerProducts($from, $to, $count);
    }
}
