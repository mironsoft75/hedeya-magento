<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data;

interface HomeDataInterface
{
    /**
     * @return \Magepotato\Banners\Api\Data\BannerInterface[]|null
     */
    public function getSliderBanners();

    /**
     * @return \Magento\Catalog\Api\Data\CategoryInterface[]|null
     */
    public function getCategories();

    /**
     * @return \Magento\Catalog\Api\Data\ProductInterface[]|null
     */
    public function getBestsellers();
}
