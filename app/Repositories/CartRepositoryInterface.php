<?php

namespace App\Repositories;

interface CartRepositoryInterface
{
    public function getUserCartById($userId);
    public function addItemToCart($userId, $itemData);
    public function updateCartItem($cartItemId, $quantity);
    public function removeItemItem($cartItemId);
    public function clearCart($userId);
}
