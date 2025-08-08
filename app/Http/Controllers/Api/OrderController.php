<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
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
}
