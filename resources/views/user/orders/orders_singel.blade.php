@extends('layout.layout')
@section('title')
  Categories
@endsection
@section('content')
    @section('extra-bread')
        <li class="breadcrumbs__item">
            <a class="breadcrumbs__link" href="profile.html">Profile</a>
        </li>
        <li class="breadcrumbs__item">
            <a class="breadcrumbs__link" href="Orders.html">Orders</a>
        </li>
        <li class="breadcrumbs__item">Orders singel</li>
    @endsection
    @include('layout.breadcrumbs')
                    
        </div>
        <div class="checkout section js-checkout">
            <div class="checkout__center center">
                <div class="checkout__stage stage">- The Order</div>
                <h2 class="checkout__title title title_mb-lg">Your Order</h2>
                <div class="checkout__col">
                    <div class="basket basket_checkout">
                        <div class="basket__category">Order</div>
                        <div class="basket__list">
                            @foreach ($items as $item)
                            <div class="basket__item">
                                <a class="basket__preview" href="#"><img class="basket__pic"
                                        src="{{$item->product->img}}" alt="" /></a>
                                <div class="basket__details">
                                    <a class="basket__product" href="#">{{$item->product->name}}</a>
                                    <div class="basket__price">
                                        <div class="basket__old">${{$item->offer_price}}</div>
                                        <div class="basket__actual">${{$item->price}}</div>
                                    </div>
                                </div>
                            </div> 
                            @endforeach
                                
                        </div>
                        <div class="basket__total">
                            <div class="basket__text">Total:</div>
                            <div class="basket__text">${{$total}}</div>
                        </div>
                        <a class="basket__button btn btn_border btn_wide" href="{{url("profile/$order->user_id/orders")}}">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
