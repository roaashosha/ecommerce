@extends('layout.layout')
@section('title')
  Address
@endsection
@section('content')
@section('extra-bread')
  <li class="breadcrumbs__item">Profile</li>
@endsection
  @include('layout.breadcrumbs') 

  @include('layout.catContainer')
<br>
    <div class="review section">
      <div class="review__center center">
        <div class="review__container">
          <div class="review__box">
            <div class="review__stage stage">- Address Location</div>
            <h2 class="review__title title">Select your address to delever</h2>
          </div>
          <div class="review__wrap">
            <div class="review__slider js-slider-review">
              @foreach ( $addresses as $address)
                <div class="review__item">
                  <div class="review__author">{{$address->type}}</div>
                  <div class="review__text">{{$address->city->name}}</div>
                  <br>
                  <div class="review__text">{{$address->street}}
                  </div>
                </div>
              @endforeach
            </div>
            <br>
            <div class="login__btns">
              <button class="login__btn btn btn_green btn_wide ">Select</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="checkout section js-checkout">
      <div class="checkout__center center">
        <div class="checkout__row">
          <div class="checkout__col">
            <div class="basket basket_checkout">
              <div class="basket__category">Add Address</div>
              <form class="login__form"method = "post"  action = "{{url("/address/$address->user_id")}}">
                @csrf  
              <div class="mapouter center">
                  <div class="gmap_canvas" id="map"><iframe
                      src="https://maps.google.com/maps?q=university%20of%20san%20francisco&amp;t=&amp;z=8&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                      frameborder="0" scrolling="no" style="width: 540px; height: 380px;"></iframe>
                    <style>
                      .mapouter {
                        display: table;
                      }

                      .gmap_canvas {
                        overflow: hidden;
                        position: relative;
                        height: 380px;
                        width: 540px;
                        background: #fff;
                      }
                    </style><a href="https://fnfmods.net/week-8/">fnf week 8</a>
                    <style>
                      .gmap_canvas iframe {
                        position: relative !important;
                        z-index: 2 !important;
                      }

                      .gmap_canvas a {
                        color: #fff !important;
                        position: absolute !important;
                        top: 0 !important;
                        left: 0 !important;
                        z-index: 0 !important;
                      }
                    </style>
                  </div>
                </div>
              <br>
              <div class="login__field field">
                <div class="field__label">house</div>
                <div class="field__wrap">
                  <input class="field__input" type="text" name="house_no"></div>
              </div>
              <div class="login__field field">
                <div class="field__label">Street</div>
                <div class="field__wrap"><input class="field__input" type="text" name="street"></div>
              </div>
              <div class="contacts__field field">
                <div class="field__label">Address Type</div>
                <div class="field__wrap"><select class="field__select wide" name="type">
                    <option value="House">House</option>
                    <option value = "Work">Work</option>
                    <option>Other</option>
                  </select>
                </div>
              </div>
              <div class="login__btns"><button class="basket__button btn btn_border btn_wide" type="submit">Add
                  Address</button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>

@endsection