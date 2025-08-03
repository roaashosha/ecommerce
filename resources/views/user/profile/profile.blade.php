@extends('layout.layout')
@section('title')
  Profile
@endsection
@section('content')
@section('extra-bread')
  <li class="breadcrumbs__item">Profile</li>
@endsection
  @include('layout.breadcrumbs') 

  @include('layout.catContainer')

    <div class="login section">
      <div class="login__details">
        <div class="login__center center">
          <div class="login__stage stage">- Address</div>
          <h2 class="login__title title title_mb-lg">
            Welcome to Your <br />Account
          </h2>
          <form class="login__form" method="post" action="{{url("/profile/$user->id")}}">
            @csrf
            @method('PUT')
            <div class="login__field field">
              <div class="field__label">Name</div>
              <div class="field__wrap">
                <input class="field__input" type="text" name="name" value="{{ old('name', $user->first_name." ".$user->last_name ?? '')}}" />
              </div>
            </div>
            <div class="login__field field">
              <div class="field__label">Phone Number</div>
              <div class="field__wrap">
                <input class="field__input" type="text" name="phone" value="{{ old('phone', $user->phone ?? '')}}" />
              </div>
            </div>
            <div class="contacts__field field">
              <div class="field__label">Language</div>
              <div class="field__wrap">
                <select class="field__select wide" name="lang" value="{{ old('lang', $user->lang ?? '')}}">
                  <option value="ar" {{ old('lang', $user->lang ?? '') == 'ar' ? 'selected' : '' }}>arabic</option>
                  <option value="en" {{ old('lang', $user->lang ?? '') == 'en' ? 'selected' : '' }}>english</option>
                </select>
              </div>
            </div>
            <div class="login__btns">
              <button class="login__btn btn btn_green btn_wide">Save</button>
            </div>
            <div class="login__row"></div>
          </form>
        </div>
      </div>
    </div>
@endsection