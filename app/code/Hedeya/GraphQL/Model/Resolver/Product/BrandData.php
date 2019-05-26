<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
declare(strict_types=1);

namespace Hedeya\GraphQl\Model\Resolver\Product;

use Hedeya\MobileApi\Api\Data\Catalog\ExtensionOptionInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\Resolver\Value;

class BrandData implements ResolverInterface
{
    protected $catalogHelper;

    public function __construct(
        \Hedeya\MobileApi\Helper\Catalog $catalogHelper
    ){
        $this->catalogHelper = $catalogHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) : array
    {
        $brands = [];
        $product = $value['model'];
        $productBrands = $this->catalogHelper->getBrandsByProduct($product);
        if($productBrands) {
            foreach ($productBrands as $brand) {
                $brands[] = new \Hedeya\MobileApi\Model\Data\ExtensionOption($brand);
            }
        }
        return $brands;
    }
}
