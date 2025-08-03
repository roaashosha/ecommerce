@extends('layout.layout')
@section('title')
  Orders
@endsection
@section('content')
    @section('extra-bread')
        <li class="breadcrumbs__item">
            <a class="breadcrumbs__link" href="profile.html">Profile</a>
        </li>
        <li class="breadcrumbs__item">
            <a class="breadcrumbs__link" href="Orders.html">Orders</a>
        </li>
    @endsection
    @include('layout.breadcrumbs')    
    @include('layout.catContainer')

        <div class="checkout section js-checkout">
            <div class="checkout__center center">
                <div class="checkout__stage stage">- Your Orders</div>
                <h2 class="checkout__title title title_mb-lg">Orders</h2>
                <h2 class="newsletter__titl title_mb-md" id="order_head">
                    <p>ID</p>
                    <p>Date</p>
                    <p>Price</p>
                    <p>Status</p>
                </h2>
                @foreach ($orders as $order)
                    <div class="newsletter__center center">
        
                        <div class="newsletter__container" id="newsletter__container2">
                            <h2 class="newsletter__title title_mb" id="order" >
                                <p>{{$order->id}}</p>
                                <p>{{$order->created_at->format('M j, Y') }}</p>
                                <p>{{$order->price}}</p>
                                <p>{{$order->status}}</p>
                                <div class="products__btns" id="order__btn">
                                    <a class="products__btn btn btn_green" href="{{url("orders/$order->id/items")}}">The Order</a>
                                </div>
                            </h2>
                        </div>
                    </div>
                    <br>
                @endforeach
            </div>
        </div>



    </div>
    </div>
@endsection