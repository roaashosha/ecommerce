<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
// use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        // $data['cats'] = Category::all();
        if (Auth::check()){
            $user = Auth::user();
            $data['cart'] = Cart::where('user_id',$user->id)->first();
            if ($data['cart']) {
                $data['cartItems'] = CartItem::where('cart_id', $data['cart']->id)->get();
                $subtotal = 0;
                foreach ($data['cartItems'] as $item) {
                    $subtotal += $item->offer_price * $item->quantity;
                }

                // Update price if not stored
                $data['cart']->price = $subtotal;
            } else {
                $data['cartItems'] = collect();
                $data['cart'] = (object)[
                    'price' => 0,
                    'discount' => 0,
                    'fees' => $data['cart']->fees,
                    'shipping' => $data['cart']->shipping,
                ];
            }
        }
        else{
            $sessionCart = session()->get('cart', []);
            $data['cartItems'] = collect();
            $subtotal = 0;

            foreach ($sessionCart as $id => $item) {
                $product = Product::find($id);
                if ($product) {
                    $data['cartItems']->push((object)[
                        'product' => $product,
                        'quantity' => $item['quantity']
                    ]);
                    $subtotal += $product->price * $item['quantity'];
                }
            }

            $data['cart'] = (object)[
                'price' => $subtotal,
                'discount' => 0,
                'fees' => 10,
                'shipping' => 20,
            ];
    }
        return view('user.cart.index')->with($data);
    }

    public function addToCart(Request $request,$id){
        $product = Product::findOrFail($id);
        if (Auth::check()){
            $user = Auth::user();
            $cartItem = CartItem::where('user_id',$user->id)
            ->where('product_id',$id)->first();
            if ($cartItem){
                $cartItem->quantity +=1;
                $cartItem->save();
            }
            else{
                CartItem::create([
                    'user_id'=>$user->id,
                    'product_id'=>$id,
                    'quantity'=>1

                ]);
            }

        }
        else{
            $cart = session()->get('cart',[]);
            if (isset($cart[$id])){
                $cart[$id]['quantity']+=1;
            }
            else{
                $cart[$id]=[
                    "name"=>$product->name,
                    "price"=>$product->price,
                    "quantity"=>1,
                    "img" =>$product->img
                ];
            }
            session()->put('cart',$cart);
        }
        return back();
    }

    public function clear(){
        if (Auth::check()){
            $user = Auth::user();
            CartItem::where('user_id',$user->id)->delete();
        }
        else{
            session()->forget('cart');
        }
        return back();
    }



}
