@extends('layout.layout')
@section('title')
  Code 
@endsection
@section('content')
        <div class="login section">
            <div class="login__details">
                <div class="login__center center">
                    <div class="login__stage stage">- Forgot Password</div>
                    <h2 class="login__title title title_mb-lg">
                        Login to Your <br />Account
                    </h2>
                    <form class="login__form" method ="POST" action="{{route("otp.verify")}}">
                        @csrf
                        <input type="hidden" name="phone" value="{{ old('phone') }}">
                        <div id="otp">
                            <input class="field__input" type="text" name="otp[]" maxlength="1"
                                oninput="moveToNext(this, 'otp2')" id="otp1" />
                            <input class="field__input" type="text" name="otp[]" maxlength="1"
                                oninput="moveToNext(this, 'otp3')" id="otp2">
                            <input class="field__input" type="text" name="otp[]" maxlength="1"
                                oninput="moveToNext(this, 'otp4')" id="otp3">
                            <input class="field__input" type="text" name="otp[]" maxlength="1"
                                oninput="moveToNext(this, 'otp5')" id="otp4">
                            <input class="field__input" type="text" name="otp[]" maxlength="1"
                                oninput="moveToNext(this, 'otp6')" id="otp5">
                            <input class="field__input" type="text" name="otp[]" maxlength="1" oninput="moveToNext(this)"
                                id="otp6">
                        </div>
                        <br>
                        <div class="login__btns">
                            <button class="login__btn btn btn_border btn_wide">Resend</button>
                        </div>
                        <div class="login__btns">
                            <button class="login__btn btn btn_green btn_wide">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
        <script>
            function moveToNext(current, nextId) {
                if (current.value.length >= 1 && nextId) {
                    document.getElementById(nextId).focus();
                }
            }
        </script>

@endsection