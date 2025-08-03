@extends('layout.layout')
@section('title')
  Change password
@endsection
@section('content')
    @section('extra-bread')
          <li class="breadcrumbs__item">
              <a class="breadcrumbs__link" href="profile.html">Change Password</a>
          </li>
      @endsection 
    @include('layout.breadcrumbs')
    @include('layout.catContainer')

    <div class="login section">
      <div class="login__details">
        <div class="login__center center">
          <div class="login__stage stage">- Change Password</div>
          <h2 class="login__title title title_mb-lg">
            Change Your <br />
            Password
          </h2>

          @if ($errors->any())
              <div class="alert alert-danger" style="color:red; margin-bottom: 15px;">
                  <ul style="list-style: none; padding: 0;">
                      @foreach ($errors->all() as $error)
                          <li>• {{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          <form class="login__form" method="post" action = "{{url("change-password/$user->id")}}"> 
            @csrf
            <div class="login__field field">
              <div class="field__label">Old Password</div>
              <div class="field__wrap">
                <input class="field__input" type="password" name="old_password" />
              </div>
            </div>
            <div class="login__field field">
              <div class="field__label">New Password</div>
              <div class="field__wrap">
                <input class="field__input" type="password" name="password" />
              </div>
            </div>
            <div class="login__field field">
              <div class="field__label">Confirm Password</div>
              <div class="field__wrap">
                <input class="field__input" type="password" name="password_confiramtion" />
              </div>
            </div>
            <div class="login__btns">
              <button class="login__btn btn btn_green btn_wide" type="submit">Save</button>
            </div>
            <div class="login__row"></div>
          </form>

        </div>
      </div>
    </div>
@endsection