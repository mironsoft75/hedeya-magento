<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-gift-registry
 * @version   1.2.10
 * @copyright Copyright (C) 2018 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\Giftr\Block\Search;

class RegistryType extends \Mirasvit\Giftr\Block\Registry\View
{
    /**
     * \Mirasvit\Giftr\Model\ResourceModel\Type\Collection
     */
    private $typeCollection;

    /**
     * @param \Mirasvit\Giftr\Model\Service\RegistrySearchService               $searchService,
     * @param \Magento\Framework\Registry                                       $registry
     * @param \Magento\Customer\Model\CustomerFactory                           $customerFactory
     * @param \Magento\Customer\Model\Session                                   $customerSession
     * @param \Magento\Framework\View\Element\Template\Context                  $context
     * @param array                                                             $data
     */
    public function __construct(
        \Mirasvit\Giftr\Model\ResourceModel\Type\Collection $typeCollection,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->typeCollection = $typeCollection;
        parent::__construct($registry, $customerFactory, $customerSession, $context, $data);
    }

    /**
     * @return $this
     */
    public function getRegistryTypeCollection()
    {
        $collection = $this->typeCollection->addFieldToFilter('is_active',1);
        $collection->getSelect()->order('sort_order DESC');

        return $collection;
    }

    /**
     * @param string $key
     * @return null|string
     */
    public function getEnteredData($key)
    {
        $value = null;

        if (null === $this->enteredData) {
            $this->enteredData = $this->customerSession
                ->getData('search_form', true);
        }

        if (!empty($this->enteredData) && isset($this->enteredData[$key])) {
            $value = $this->enteredData[$key];
        }

        return $value;
    }

    /**
     * @param \Mirasvit\Giftr\Model\Registry $registry
     * @return void
     */
    public function setRegistry(\Mirasvit\Giftr\Model\Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return string
     */
    public function getRegistryUrl()
    {
        return $this->getRegistry()->getViewUrl();
    }

    /**
     * @return \Mirasvit\Core\Helper\Image
     */
    // public function getImageUrl()
    // {
    //     return $this->getRegistry()->getImageUrl(500, 200);
    // }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function addTitleBlock()
    {
        $this->pageConfig->getTitle()->set(__('Gift Registry Search'));

        return $this;
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function addBreadcrumbBlock()
    {
        if ($breadcrumb = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumb->addCrumb('home', [
                'label' => __('Home'),
                'title' => __('Home Page'),
                'link' => $this->getBaseUrl(),
            ])->addCrumb('giftr_search', [
                'label' => __('Gift Registry Search'),
                'title' => __('Gift Registry Search'),
            ]);
        }

        return $this;
    }
}
