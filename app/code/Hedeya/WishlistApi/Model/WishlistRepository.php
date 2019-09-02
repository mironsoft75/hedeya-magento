<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\WishlistApi\Model;

use Hedeya\WishlistApi\Api\WishlistInterface;

class WishlistRepository implements \Hedeya\WishlistApi\Api\WishlistRepositoryInterface
{
    private $http;
    private $tokenFactory;
    private $wishlistFactory;
    private $productRepository;
    private $itemResource;
    private $customerSession;

    public function __construct(
        \Magento\Framework\App\Request\Http $http,
        \Magento\Integration\Model\Oauth\TokenFactory $tokenFactory,
        // \Magento\Wishlist\Model\WishlistFactory $wishlistFactory,
        \Hedeya\WishlistApi\Model\WishlistFactory $wishlistFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Wishlist\Model\ResourceModel\Item $itemResource,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->http = $http;
        $this->tokenFactory = $tokenFactory;
        $this->wishlistFactory = $wishlistFactory;
        $this->productRepository = $productRepository;
        $this->itemResource = $itemResource;
        $this->customerSession = $customerSession;
    }

    public function getByCustomerId($customerId): WishlistInterface
    {
        $wishlist = $this->wishlistFactory->create();
        $wishlist->loadByCustomerId($customerId);

        if (!$wishlist->getId()) {
            $wishlist->setCustomerId($customerId);
            $wishlist->getResource()->save($wishlist);
        }

        return $wishlist;
    }

    public function addItem(string $sku): bool
    {
        $product = $this->productRepository->get($sku);
        $wishlist = $this->getCurrentWishlist();
        $wishlist->addNewItem($product);

        return true;
    }

    public function removeItem(int $itemId): bool
    {
        $wishlist = $this->getCurrentWishlist();
        $item = $wishlist->getItem($itemId);
        if (!$item) {
            return false;
        }
        $this->itemResource->delete($item);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentWishlist(): WishlistInterface
    {
        $customerId = $this->customerSession->getCustomerId();
        if (!$customerId) {
            $authorizationHeader = $this->http->getHeader('Authorization');
            $tokenParts = explode('Bearer', $authorizationHeader);
            $tokenPayload = trim(array_pop($tokenParts));
            /** @var Token $token */
            $token = $this->tokenFactory->create();
            $token->loadByToken($tokenPayload);
            $customerId = $token->getCustomerId();
        }
        /** @var Wishlist $wishlist */
        $wishlist = $this->wishlistFactory->create();
        $wishlist->loadByCustomerId($customerId);
        if (!$wishlist->getId()) {
            $wishlist->setCustomerId($customerId);
            $wishlist->getResource()->save($wishlist);
        }

        return $wishlist;
    }


}
