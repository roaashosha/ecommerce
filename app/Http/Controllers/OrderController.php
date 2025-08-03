<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($id){
        // $data['cats'] = Category::all();
        $data['orders'] = Order::where('user_id',$id)->get();
        return view('user.orders.orders')->with($data);

    }

    public function orderDetails($id){
        // $data['cats'] = Category::all();
        $data['order'] = Order::findOrFail($id);
        $data['items'] = OrderItem::where('order_id',$data['order']->id)->get();
        $data['total'] = $data['items']->sum('offer_price');
        return view('user.orders.orders_singel')->with($data);

    }
}
