<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\RokanBrand\Model;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Brand extends \Rokanthemes\Brand\Model\Brand {
    protected $categoryRepository;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $url,
        \Rokanthemes\Brand\Helper\Data $brandHelper,
        CategoryRepositoryInterface $categoryRepository,
        \Rokanthemes\Brand\Model\ResourceModel\Brand $resource = null,
        \Rokanthemes\Brand\Model\ResourceModel\Brand\Collection $resourceCollection = null,
        array $data = []
    ) {
        $this->categoryRepository = $categoryRepository;
        parent::__construct( $context, $registry, $resource, $resourceCollection, $productCollectionFactory, $storeManager, $url, $brandHelper, $data );
    }

    public function getCategory()
    {
        try {
            return $this->categoryRepository->get($this->getData('category_id'));
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getUrl() {
        if ($this->getCategory() !== null) {
            return $this->getCategory()->getUrl();
        }

        return parent::getUrl();
    }

    public function getImageUrl()
    {
        if ($this->getCategory() !== null) {
            return $this->getCategory()->getImageUrl('mapi_category_icon');
        }

        return parent::getImageUrl();
    }

    public function getThumbnailUrl()
    {
        if ($this->getCategory() !== null) {
            return $this->getCategory()->getImageUrl('mapi_category_icon');
        }

        return parent::getThumbnailUrl();
    }
}
