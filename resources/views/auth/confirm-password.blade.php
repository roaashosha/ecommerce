@extends('layout.layout')
@section('title')
  Confirm Password
@endsection
@section('content')
    @section('extra-bread')
          <li class="breadcrumbs__item">
              <a class="breadcrumbs__link" href="profile.html">Confirm Password</a>
          </li>
      @endsection 
    @include('layout.breadcrumbs')
        <div class="login section">
            <div class="login__details">
                <div class="login__center center">
                    <div class="login__stage stage">- Change Password</div>
                    <h2 class="login__title title title_mb-lg">
                        Change Your <br />
                        Password
                    </h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form class="login__form" method = "POST" action ="{{route('password.update')}}">
                        @csrf
    <!-- Email field is required -->
                        <div class="login__field field">
                            <div class="field__wrap">
                                <input type="hidden" name="phone" value="{{ $phone }}">
                            </div>
                        </div>

                         <input type="hidden" name="otp" value="{{ is_array($otp) ? implode('', $otp) : $otp }}">


                        <div class="login__field field">
                            <div class="field__label">New Password</div>
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
                        <div class="login__btns">
                            <button class="login__btn btn btn_green btn_wide">Save</button>
                        </div>
                        <div class="login__row"></div>
                    </form>
                </div>
            </div>
        </div>
@endsection
{{-- 
@section('scripts')
    <script>
        let otp = '';
        for (let i = 1; i <= 6; i++) {
            otp += document.getElementById('otp' + i).value;
        }
        document.getElementById('otp').value = otp;

    </script>
@endsection --}}