@extends('layout.layout')
@section('title')
  Home
@endsection
@section('content')
 <!-- Swiper container and slides -->
    @include('layout.swiper')
    <div class="categories section">
      <div class="categories__center center">
        <div class="categories__stage stage">- The Categories</div>
        <h2 class="categories__title title title_mb-lg">
          Browse by Category
        </h2>
        <div class="categories__container">
          <div class="categories__slider js-slider-categories">
            @foreach ($cats  as  $cat)
              <div class="categories__slide">
                <a class="categories__item" href={{url("/categories/{$cat->id}")}}>
                  <div class="categories__icon">
                    <img class="categories__pic" src="{{asset("$cat->img")}}" alt="" />
                  </div>
                  <div class="categories__text">{{$cat->name}}</div>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <!--  -->
    <div class="products products_main section">
      <div class="products__center center">
        <div class="products__stage stage">- Our Products</div>
        <h2 class="products__title title title_mb-lg">
          Explore out Products
        </h2>
        <div class="products__list">
          @foreach ($prods as $prod )
            <div class="product">
              @if ($prod->offer >0)
                <div class="product__sale">{{$prod->offer}}% OFF</div>           
              @endif
              <div class="product__view">
                <a class="product__preview" href="{{url("/products/$prod->id")}}"><img class="product__pic"
                    src="{{asset("$prod->img")}}" alt="" /></a><a class="product__btn btn btn_green"
                  href="{{url("cart/add/$prod->id")}}">Add to Cart</a>
              </div>
              <a class="product__name" href="{{url("/products/$prod->id")}}">{{$prod->name}}</a>
              <div class="product__details">
                <div class="product__category yellow">{{$prod->category->name}}</div>
                <div class="product__price">
                  @if ($prod->offer >0)
                    <span class="product__old">${{$prod->price}}</span>
                  @endif
                  <span class="product__actual">${{($prod->price)-($prod->offer)}}</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="products__btns">
          {{-- <a class="products__btn btn btn_green" href="{{url("category/$cat")}}">View All</a> --}}
        </div>
      </div>
    </div>


    @include('layout.about')
    @include('layout.review')
    @include('layout.blog')
    @include('layout.news')
    
  @endsection
  <!-- scripts-->

  @section('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
      var swiper = new Swiper(".swiper-container", {
        loop: true,
        cssMode: true,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        mousewheel: true,
        keyboard: true,
        autoplay: {
          delay: 5000,
        },
      });
    </script>
@endsection
