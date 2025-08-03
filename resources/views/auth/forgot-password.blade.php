@extends('layout.layout')
@section('title')
  Forget Password
@endsection
@section('content')
    @include('layout.breadcrumbs')
        <div class="login section">
            <div class="login__details">
                <div class="login__center center">
                    <div class="login__stage stage">- Forgot Password</div>
                    <h2 class="login__title title title_mb-lg">
                        Login to Your <br />Account
                    </h2>

                    @if ($errors->has('phone'))
                        <div class="text-danger">{{ $errors->first('phone') }}</div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- <form class="login__form" method="POST" action="{{route('sendLink')}}"> --}}
                    <form class="login__form" method="POST" action="{{route('send.otp')}}">
                        @csrf
                        <div class="login__field field">
                            <div class="field__label">Enter Your Phone Number</div>
                            <div class="field__wrap">
                                <input class="field__input" type="text" name="phone" />
                            </div>
                        </div>
                        <div class="login__btns">
                            <button class="login__btn btn btn_green btn_wide">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
@endsection