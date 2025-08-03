@extends('layout.layout')
@section('title')
  Login
@endsection
@section('content')
@include('errors')
    <div class="breadcrumbs">
      <div class="breadcrumbs__center center">
        <ul class="breadcrumbs__list">
          <li class="breadcrumbs__item">
            <a class="breadcrumbs__link" href="index.html">Home Page</a>
          </li>
          <li class="breadcrumbs__item">
            <a class="breadcrumbs__link" href="category.html">Categories</a>
          </li>
          <li class="breadcrumbs__item">Login</li>
        </ul>
      </div>
    </div>
    <div class="login section">
      <div class="login__details">
        <div class="login__center center">
          <div class="login__stage stage">- Login</div>
          <h2 class="login__title title title_mb-lg">
            Login to Your <br />Account
          </h2>
          <form class="login__form" method="POST" action ="{{url('/login')}}">
            @csrf
            <div class="login__field field">
              <div class="field__label">Phone Number</div>
              <div class="field__wrap">
                <input class="field__input" type="text" name="phone" />
              </div>
            </div>
            <div class="login__field field">
              <div class="field__label">Password</div>
              <div class="field__wrap">
                <input class="field__input" type="password" name="password" />
              </div>
            </div>
            <label class="login__checkbox checkbox"><input class="checkbox__input js-checkout-checkbox" type="checkbox"
                checked /><span class="checkbox__in">
                  <span class="checkbox__tick"></span>
                  <span class="checkbox__text">Remember me</span></span></label>
            <div class="login__btns">
              <button class="login__btn btn btn_green btn_wide">Login</button>
            </div>
            <div class="login__row">
              <div class="login__col">
                <a class="login__btn btn btn_border btn_wide" href="sign-up.html">Create Account
                </a>
              </div>
              <div class="login__col">
                <a class="login__link" href="{{url("/forget-password")}}">Forgot Password?</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
@endsection
