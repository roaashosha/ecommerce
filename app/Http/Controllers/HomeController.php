<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        // $data['cats'] = Category::all();
        $data['prods'] = Product::take(8)->get();
        // $data['cart'] = Cart::all();
        $data['id'] = Auth::check() ? Auth::id() : null;
        $cartData = $this->getCartItems();
        $data['cartItems'] = $cartData['cartItems'];
        $data['total'] = $cartData['total'];
        return view("user.home.index")->with($data);
    }

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

    return [
        'cartItems' => $cartItems,
        'total' => $total
    ];
}

}
