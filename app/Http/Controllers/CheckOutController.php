<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\City;
use App\Models\Zipcode;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
// use App\Models\Category;
class CheckOutController extends Controller
{
    public function index(){
        // $data['cats'] = Category::all();
        // $data['cat']= Category::findOrFail($id);
        $cartData = $this->getCartItems();
        $data['cartItems'] = $cartData['cartItems'];
        $data['total'] = $cartData['total'];
        return view('user.checkout.checkout')->with($data);
    }
    public function submit(Request $request){
        $action= $request->input('action');
        $step = $request->input('step', 1);
        if ($step === 1){
            if ($action === "auth"){
                $credentials = $request->only("email","password");
                if (Auth::attempt($credentials)){
                    Session::put('checkout_user',Auth::user->id);
                }
                else{
                    return back()->withErrors(["email"=>"invalid credentials"]);
                }
    
            }
            else{
                Session::put('checkout_user','guest_'.uniqid());
            }
            return back()->with("step",2);
        }
        

        if ($step ===2){
            $shipping =$request->validate([
                'name' => 'required|string',
                'street' => 'required|string',
                'house' => 'required|string',
                'city' => 'required|string',
                'country' => 'required|string',
                'code' => 'required|string'
            ]);
            $city_id = City::select('name',$shipping['city'])->id;
            $country_id = Country::select('name',$shipping['country'])->id;
            $zipCode_id = Zipcode::select('name',$shipping['code']);
            $billingAddress = Address::create($country_id,'',$city_id,'',$zipCode_id,$shipping['street'],$shipping['house']);
            Session::put('checkout_shipping_id', $shippingAddress->id);
            return back()->with('step', 3);


        }

        if ($step ===3){
            if ($request->has('same_as_shipping')) {
                $billingAddressId = Session::get('checkout_shipping_id');
            } else {
                $billing = $request->validate([
                    'name' => 'required|string',
                    'street' => 'required|string',
                    'house' => 'required|string',
                    'city' => 'required|string',
                    'country' => 'required|string',
                    'code' => 'required|string'
                ]);

            }
            $city_id = City::select('name',$shipping['city'])->id;
            $country_id = Country::select('name',$shipping['country'])->id;
            $zipCode_id = Zipcode::select('name',$shipping['code']);
            $billingAddress = Address::create($country_id,'',$city_id,'',$zipCode_id,$shipping['street'],$shipping['house']);
            Session::put('checkout_shipping_id', $shippingAddress->id);
            return back()->with('step', 4);
        
        }
        if ($step==4){
            $request->validate([
                'payment' => 'required|string|in:Credit Card,PayPal',
                'card' => 'nullable|string',
                'date' => 'nullable|string',
                'cvv' => 'nullable|string',
            ]);

            $userId = Session::get('checkout_user');
            $shippingId = Session::get('checkout_shipping_id');

            $cart = session()->get('cart', []);
            $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            $order = Order::create([
                'user_id'=>is_numeric($userId)?$userId : null,
                'price'=>$totalPrice,
                'address_id'=>$shippingId,
                "status"=>"pending",
                "active"=>1
            ]);
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }
            session()->forget(['cart', 'checkout_user', 'checkout_shipping_id', 'checkout_billing_id']);
            return view('user.home.index');

        }
        return back()->withErrors(['step' => 'Invalid checkout step.']);
    }

    public function showCartItems(){
        $cart = session()->get('cart', []);
        $cartItems = [];

        foreach ($cart as $productId => $item) {
            $product =Product::find($productId);

        
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                ];
            }
        }

        return view('user.cart.index', compact('cartItems'));
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
