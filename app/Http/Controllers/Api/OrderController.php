<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponseTrait;
    public function userOrders(Request $request,$id=null){
        $user = auth()->user();
        if ($user){
            $id = $user->id;
        }else if (!$id && $request->session()->has('user_id')){
            $id = $request->session()->get('user_id');
        }
        if(!$id){
            return $this->ApiResponse(null,"No user found!",401);
        }
        $orders = Order::select('id','price','created_at','status')->where('user_id',$id)->get();
        if ($orders->isEmpty()){
            return $this->ApiResponse(null, "Order is not found!", 404);
        }
        return $this->ApiResponse(OrderResource::collection($orders),"Orders are returned successfully!",200);
    }

    public function orderItems($id){
        $order = Order::find($id);
        if (!$order){
            return $this->ApiResponse(null,"Order is not found!",404);
        }
        $user = auth()->user() ?? session('user');
        if (!$user){
            return $this->ApiResponse(null,"Unauthenticated!",401);   
        }

        if ($order->user_id != $user->id){
            return $this->ApiResponse(null,"Unauthorized",403);
        }
        $orderItems = OrderItem::where('order_id',$id)->get();
        $totalPrice=$orderItems->sum(function($item){
            return $item->offer_price*$item->count;
        });
        return $this->ApiResponse(['items'=>OrderItemResource::collection($orderItems),"total_price"=>$totalPrice],"Order items are returned successfully!",200);
    }

    public function submitOrder(Request $request){
        $user = auth()->user();
        if (!$user){
            return $this->ApiResponse(null,"Unauthenticated!",401);   
        }
        $request->validate([
            "items"=>"required|array",
            "items.*.product_id"=>"required|integer|exists:products,id",
            "items.*.quantity"=>"required|integer|min:1",
        ]);
        $addressId = $user->address_id ?? null; 
        if (!$addressId)
        {
            return $this->ApiResponse(null, "No address found for user!", 400);
        }

        $order = Order::create([
            "user_id"=>$user->id,
            "status"=>"pending",
            "price"=>0,
            "address_id"=>$user->address_id,
            "active"=>1,
            "payment_method" => "cash",
            "payment_status" => "pending" 
        ]);

        $totalPrice = 0;
        foreach ($request->items as $item) {
        $product = Product::find($item['product_id']); // get product details
        $price = $product->price;
        $quantity = $item['quantity'];

        $offer = 10; 
        $offerPrice = $price - ($price * ($offer / 100));

        OrderItem::create([
            "order_id" => $order->id,
            "product_id" => $item['product_id'],
            "category_id" => $product->category_id,
            "active" => 1,
            "count" => $quantity,
            "offer" => $offer,
            "price" => $price,
            "offer_price" => $offerPrice
        ]);

        $totalPrice += $offerPrice * $quantity;
    }
    $order->update([
        "price" => $totalPrice
    ]);

    return $this->ApiResponse(null, "Order Created Successfully!", 200);

        
    }
}
