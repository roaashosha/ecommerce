<?php

namespace App\Http\Controllers ;

use App\Models\Product;

trait HelperTrait{
    private function getCartItems() {
    $cart = session()->get('cart', []);
    $cartItems = [];
    $total = 0;
    foreach ($cart as $productId => $item) {
        $product = Product::find($productId);
        if ($product) {
            $cartItems[] = (object)[
                'product' => $product,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ];
        }
    }
}

}