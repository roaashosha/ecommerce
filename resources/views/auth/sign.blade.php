@extends('layout.layout')
@section('title')
  Sign Up
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
          <li class="breadcrumbs__item">Sign Up</li>
        </ul>
      </div>
    </div>
      <div class="login section">
      <div class="login__details">
        <div class="login__center center" >
          <div class="login__stage stage">- Sign Up</div>
          <h2 class="login__title title title_mb-lg">Create Account</h2>
          <form class="login__form" method="POST" action ="{{url('/signup')}}">
            @csrf
            <div class="login__wrap">
              <div class="login__status success"></div>
              <div class="login__field field">
                <div class="field__label">Phone Number</div>
                <div class="field__wrap">
                  <input class="field__input" type="text" name="phone" />
                </div>
              </div>
              <div class="login__field field">
                <div class="field__label">Create Password</div>
                <div class="field__wrap">
                  <input class="field__input" type="password" name="password" />
                </div>
              </div>
              <div class="login__field field">
                <div class="field__label">Confirm Password</div>
                <div class="field__wrap">
                  <input class="field__input" type="password" name="password_confirmation" />
                </div>
              </div>
            </div>
            <label class="login__checkbox checkbox">
              <input class="checkbox__input js-checkout-checkbox" type="checkbox" name="agree" checked />
              <span class="checkbox__in">
                <span class="checkbox__tick"></span><span class="checkbox__text">I
                  have read and agree to
                  <a class="checkbox__link" href="legal-page.html">terms & conditions</a></span></span></label>
            <div class="login__row">
              <div class="login__col">
                <button class="login__btn btn btn_green btn_wide">
                  Create Account
                </button>
              </div>
              <div class="login__col">
                <a class="login__btn btn btn_border btn_wide" href="login.html">Login</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    
@endsection