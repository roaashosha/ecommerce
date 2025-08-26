<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
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

    // public function selectItems(Request $request, $cartId)
    // {
    //     $cart = Cart::find($cartId);
    //     if (!$cart) {
    //         return $this->ApiResponse(null, "Cart not found!", 404);
    //     }

    //     $user = auth()->user() ?? session('user');
    //     if (!$user) {
    //         return $this->ApiResponse(null, "Unauthenticated!", 401);
    //     }

    //     if ($cart->user_id != $user->id) {
    //         return $this->ApiResponse(null, "Unauthorized!", 403);
    //     }

    //     $productIds = $request->input('product_ids', []); 

    //     if (!empty($productIds)) {
    //         $cartItems = CartItem::where('cart_id', $cartId)
    //             ->whereIn('product_id', $productIds)
    //             ->with('product')
    //             ->get();
    //     } else {
    //         $cartItems = CartItem::where('cart_id', $cartId)
    //             ->with('product')
    //             ->get();
    //     }

    //     if ($cartItems->isEmpty()) {
    //         return $this->ApiResponse(null, "No products found in cart!", 404);
    //     }

    //     return $this->ApiResponse(
    //         CartItemResource::collection($cartItems),
    //         "Products selected successfully!",
    //         200
    //     );
    // }

    public function deleteItem($cartId,$productId){
        $cartItem = CartItem::where('cart_id',$cartId)->where('product_id',$productId)->first();
        if (!$cartItem){
            return $this->ApiResponse(null,"Item is not found in cart!",404);
        }
        $cartItem->delete();
        return $this->ApiResponse(null,"Item removed Successfully!",200);
    }

    public function addItem(Request $request, $id)
    {
    $request->validate([
        "product_id" => "required|integer",
        "quantity"   => "required|integer|min:1"
    ]);

    $cart    = Cart::findOrFail($id);
    $product = Product::findOrFail($request->product_id);

    // Check if item already exists in cart
    $cartItem = $cart->cartItems()->where('product_id', $request->product_id)->first();

    if ($cartItem) {
        // Just update quantity
        $cartItem->quantity += $request->quantity;
        $cartItem->save();
    } else {
        // Create new cart item
        $cart->cartItems()->create([
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
            'price'      => $product->price,
        ]);
    }

    return $this->ApiResponse(null, "Item added/updated successfully!", 200);
    }

    public function updateQuantity(Request $request , $cartId,$productId){
        $request->validate([
            "quantity"=>"required|integer|min:1"
        ]);

        $cartItem = CartItem::where('cart_id',$cartId)->where('product_id',$productId)->first();
        if (!$cartItem){
            return $this->ApiResponse(null,"Item is not found!",404);

        }
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        return $this->ApiResponse(new CartItemResource($cartItem),"Quantity updated successfuly!",200);


    }

    



}
