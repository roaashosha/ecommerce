<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponseTrait;
    public function cartDetails(Request $request,$id=null){
        $user = auth()->user();
        if ($user){
            $id = $user->id;
        }else if (!$id && $request->session()->has('user_id')){
            $id = $request->session()->get('user_id');
        }
        if(!$id){
            return $this->ApiResponse(null,"No user found!",401);
        }
        $cart = Cart::where('user_id',$id)->get();
        if ($cart->isEmpty()){
            return $this->ApiResponse(null, "Cart is not found!", 404);
        }
        return $this->ApiResponse(CartResource::collection($cart),"Cart is found successfully!",200);
    }
    public function cartItems($id){
        $cart = Cart::find($id);
        if (!$cart){
            return $this->ApiResponse(null,"Cart is not found!",404);
        }
        $user = auth()->user() ?? session('user');
        if (!$user){
            return $this->ApiResponse(null,"Unauthenticated!",401);   
        }

        if ($cart->user_id != $user->id){
            return $this->ApiResponse(null,"Unauthorized",403);
        }
        $cartItems = CartItem::where('cart_id',$id)->with("product")->get();
        return $this->ApiResponse(CartItemResource::collection($cartItems),"Cart items are returned successfully!",200);
    }
}
