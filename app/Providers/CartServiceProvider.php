<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layout.layout',function($view){
            $cart =  session()->get('cart',[]);
            $cartItems = [];
            $total = 0 ;

            foreach ($cart  as $productId => $item){
                $product = Product::find($productId);
                if ($product){
                    $cartItems[]= (object)[
                        "product"=>$product,
                        "quantity"=>$item['quantity'],
                        "price"=>$item['price'],
                        "total" =>$item['quantity']*$item['price']
                    ];
                    $total +=$item['quantity'] *$item['price'];
                }
            }
            $view->with('layoutCartItems', $cartItems)->with('layoutCartTotal', $total);
        });
    }
}
