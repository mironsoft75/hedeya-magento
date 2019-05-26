<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Helper;

use Magento\Framework\DataObject;
use Magento\Catalog\Api\Data\ProductInterface;
use Hedeya\MobileApi\Model\Data\ExtensionOption;

class ProductExtension extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $productExtensionFactory;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Api\Data\ProductExtensionFactory $productExtensionFactory,
        \Hedeya\MobileApi\Helper\Catalog $catalogHelper
    ) {
        $this->productExtensionFactory = $productExtensionFactory;
        $this->catalogHelper = $catalogHelper;
        parent::__construct($context);
    }

    public function getExtensionAttributes(ProductInterface $product)
    {
        $extensionAttributes = $product->getExtensionAttributes();
        if(null === $extensionAttributes) {
            $extensionAttributes = $this->productExtensionFactory->create();
        }
        // product brands
        if($brands = $this->catalogHelper->getBrandsByProduct($product)) {
            $extensionAttributes->setBrandData($brands);
        }
        // additional information
        if($additionalInformation = $this->catalogHelper->getAdditionalInformation($product)) {
            $extensionAttributes->setAdditionalInformation($additionalInformation);
        }
        return $extensionAttributes;
    }



}
