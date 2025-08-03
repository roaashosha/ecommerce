@extends('layout.layout')
@section('title')
  About Us
@endsection
@section('content')
    @section('extra-bread')
      <li class="breadcrumbs__item">Frequantly Asked Questions</li>
    @endsection
    <div class="contacts section">
      <div class="contacts__details">
        <div class="contacts__center center">
          <div class="contacts__stage stage">- Ask Questions</div>
          <h2 class="contacts__title title">
            We are always here to <br />help you
          </h2>
          <div class="contacts__list">
            <div class="contacts__item">
              <div class="contacts__category">Customer Services</div>
              <div class="contacts__text">
                Please send us an email at
                <a class="contacts__link" href="mailto:customercare@hygge.com">customercare@hygge.com</a>
              </div>
            </div>
            <div class="contacts__item">
              <div class="contacts__category">Public Relations</div>
              <div class="contacts__text">
                You can contact our media team by sending them an email at
                <a class="contacts__link" href="mailto:media@hygge.com">media@hygge.com</a>
              </div>
            </div>
            <div class="contacts__item">
              <div class="contacts__category">Large Orders</div>
              <div class="contacts__text">
                If you are thinking of making a very large order, plese feel
                free to contact us at
                <a class="contacts__link" href="mailto:sales@hygge.com">sales@hygge.com</a>
                and we will give you a special discount
              </div>
            </div>
            <div class="contacts__item">
              <div class="contacts__category">Other Enquiries</div>
              <div class="contacts__text">
                For all of your other questions, please send us an email at
                <a class="contacts__link" href="mailto:general@hygge.com">general@hygge.com</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="contacts__container">
        <div class="contacts__center center">
          <div class="contacts__row">
            <div class="contacts__wrap">
              <div class="contacts__stage stage">- Reach Out to Us</div>
              <h2 class="contacts__title title">
                Please fill out the contact form
              </h2>
            </div>
            <form class="contacts__form" action = {{url('/contact/send')}} method = "post">
              @csrf
              <div class="contacts__field field">
                <div class="field__label">Full Name</div>
                <div class="field__wrap">
                  <input class="field__input" type="text" name="name" />
                </div>
              </div>
              <div class="contacts__field field">
                <div class="field__label">Email Address</div>
                <div class="field__wrap">
                  <input class="field__input" type="text" name="address" />
                </div>
              </div>
            
              <div class="contacts__field field field_textarea">
                <div class="field__label">Message</div>
                <div class="field__wrap">
                  <textarea class="field__textarea" name="message"></textarea>
                </div>
              </div>
              <button class="contacts__btn btn btn_green" type="submit">
                Send
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @include('layout.newsletter')
@endsection