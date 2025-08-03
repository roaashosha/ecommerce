@extends('layout.layout')
@section('title')
  Products
@endsection
@section('content')    
    <div class="breadcrumbs">
      <div class="breadcrumbs__center center">
        <ul class="breadcrumbs__list">
          <li class="breadcrumbs__item">
            <a class="breadcrumbs__link" href="index.html">Home Page</a>
          </li>
          <li class="breadcrumbs__item">
            <a class="breadcrumbs__link" href="category.html">Categories</a>
          </li>
          <li class="breadcrumbs__item">Shopping Cart</li>
        </ul>
      </div>
    </div>
    
    <div class="cart section">
      <div class="cart__center center">
        <div class="cart__head">
          <div class="cart__box">
            <div class="cart__stage stage">- Your Cart</div>
            <h2 class="cart__title title">Shopping Cart</h2>
          </div>
          <form method="post" action="{{url("/cart")}}">
            @csrf
              <button class="cart__btn btn btn_border" >Clear All</button>
          </form>
        </div>
        <div class="cart__row">
          <div class="cart__col">
            <div class="cart__list">
              @foreach ($cartItems as $cartItem)
                <div class="cart__item">
                  <a class="cart__preview" href="#"><img class="cart__pic" src="{{$cartItem->product->img}}"
                      alt="" /></a>
                  <div class="cart__details">
                    <a class="cart__product" href="#">{{$cartItem->product->name}}</a>
                    <div class="cart__price">
                      <div class="cart__actual">$ {{$cartItem->product->price}}</div>
                    </div>
                    <div class="cart__control">
                      <div class="cart__counter counter js-counter">
                        <button class="counter__btn counter__btn_minus js-counter-minus" type="button">
                          <svg class="icon icon-arrow-prev">
                            <use xlink:href="img/sprite.svg#icon-arrow-prev"></use>
                          </svg></button><input class="counter__input js-counter-input" type="text" value="1"
                          size="3" /><button class="counter__btn counter__btn_plus js-counter-plus" type="button">
                          <svg class="icon icon-arrow-next">
                            <use xlink:href="img/sprite.svg#icon-arrow-next"></use>
                          </svg>
                        </button>
                      </div>
                      <button class="cart__remove">
                        <svg class="icon icon-close">
                          <use xlink:href="img/sprite.svg#icon-close"></use>
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>
              @endforeach
              
            </div>
          </div>
          <div class="cart__col">
            <div class="cart__receipt">
              <div class="cart__category">Cart Total</div>
              <div class="cart__wrap">
                <div class="cart__line">
                  <div class="cart__text">Subtotal:</div>
                  <div class="cart__text">${{$cart->price - $cart->discount}}</div>
                </div>
                <div class="cart__line">
                  <div class="cart__text">Tax:</div>
                  <div class="cart__text">${{$cart->fees}}</div>
                </div>
                <div class="cart__line">
                  <div class="cart__text">Shipping:</div>
                  <div class="cart__text">${{$cart->shipping}}</div>
                </div>
                <div class="cart__line cart__line_total">
                  <div class="cart__text">Total:</div>
                  <div class="cart__text">${{$cart->price - $cart->discount + $cart->fees+ $cart->shipping  }}</div>
                </div>
              </div>
              <a class="cart__btn btn btn_green btn_wide" href="checkout.html">Checkout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    @include('layout.newsletter');
@endsection