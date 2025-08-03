<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="utf-8" />
  <title>@yield('title')</title>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta name="theme-color" content="#fff" />
  <meta name="format-detection" content="telephone=no" />
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset("img/apple-touch-icon.png")}}" />
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset("img/favicon-32x32.png")}}" />
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset("img/favicon-16x16.png")}}" />
  <link rel="manifest" href="img/site.webmanifest" />
  <meta name="msapplication-TileColor" content="#da532c" />
  <meta name="Hygge HTML Templates"
    content="11 production-ready, fully responsive HTML templates for e-Commerce projects" />
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@ui8" />
  <meta name="twitter:title" content="Hygge HTML Templates" />
  <meta name="twitter:description"
    content="11 production-ready, fully responsive HTML templates for e-Commerce projects" />
  <meta name="twitter:creator" content="@ui8" />
  <meta name="twitter:image" content="http://www.example.com/image.jpg" />
  <meta property="og:title" content="Hygge HTML Templates" />
  <meta property="og:type" content="Article" />
  <meta property="og:url" content="https://ui8.net/ui8/products/hygge-ecommerce" />
  <meta property="og:image" content="http://example.com/image.jpg" />
  <meta property="og:description"
    content="Hygge HTML Templates” content=“11 production-ready, fully responsive HTML templates for e-Commerce projects" />
  <meta property="og:site_name" content="Hygge" />
  <meta property="fb:admins" content="132951670226590" />
  <link rel="stylesheet" media="all" href="{{asset("css/app.css")}}" />
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  @yield('child-style')
  <script>
    var viewportmeta = document.querySelector('meta[name="viewport"]');
    if (viewportmeta) {
      if (screen.width < 375) {
        var newScale = screen.width / 375;
        viewportmeta.content =
          "width=375, minimum-scale=" +
          newScale +
          ", maximum-scale=1.0, user-scalable=no, initial-scale=" +
          newScale +
          "";
      } else {
        viewportmeta.content =
          "width=device-width, maximum-scale=1.0, initial-scale=1.0";
      }
    }
  </script>
</head>

<body>
  <div class="page">
    <header class="header js-header">
      <div class="header__center center">
        <button class="header__burger js-header-burger"></button><a class="header__logo" href="{{url('/')}}"><img
            class="header__pic header__pic_black-desktop" src="{{asset("img/05_logo.png")}}" alt="" /><img
            class="header__pic header__pic_white-desktop" src="{{asset("img/05_logo.png")}}" alt="" /><img
            class="header__pic header__pic_black-mobile" src="{{asset("img/05_logo.png")}}" alt="" /><img
            class="header__pic header__pic_white-mobile" src="{{asset("img/05_logo.png")}}"  alt="" /></a>
        
            <div class="header__control">
          <div class="header__item header__item_hidden">
            <div class="header__search search js-search">
              <div class="search__wrap">
                <input class="search__input" type="text" placeholder="Eye care products for tired eyes" />
              </div>
              <button class="search__btn js-search-btn">
                <svg class="icon icon-search">
                  <use xlink:href="{{asset("img/sprite.svg#icon-search")}}" ></use>
                </svg>
              </button>
            </div>
          </div>
          <div class="header__item">
            <a class="header__link header__link_cart active" href="{{url('/cart')}}"><svg class="icon icon-cart">
                <use xlink:href="{{asset("img/sprite.svg#icon-cart")}}"></use>
              </svg>
            </a>
            <div class="header__body">
              <div class="basket basket_header">
                <div class="basket__list">
                  @if (count($layoutCartItems))
                    @foreach($layoutCartItems as $item)
                    <div class="basket__item">
                      <a class="basket__preview" href="{{url("/cart")}}"><img class="basket__pic" src="{{$item->product->img}}"
                          alt="" /></a>
                      <div class="basket__details">
                        <a class="basket__product" href="#">{{$item->product->name}}</a>
                        <div class="basket__price">
                          <div class="basket__old">$ {{$item->product->price}}</div>
                          <div class="basket__actual">$ {{$item->product->offer_price}}</div>
                        </div>
                      </div>
                      <button class="basket__remove">
                        <svg class="icon icon-close">
                          <use xlink:href="{{asset("img/sprite.svg#icon-close")}}""></use>
                        </svg>
                      </button>
                    </div>
                    @endforeach
                  @endif
                <div class="basket__total">
                  <div class="basket__text">Total:</div>
                  <div class="basket__text">${{$layoutCartTotal}}</div>
                </div>
                <div class="basket__btns">
                  <a class="basket__btn btn btn_green" href="{{url('/checkout')}}">Checkout </a><a
                    class="basket__btn btn btn_border" href="{{url('/cart')}}">Edit Cart</a>
                </div>
              </div>
            </div>
          </div>
          @guest
            <div class="header__item header__item_hidden">
              <a class="header__link" href="{{url('login')}}"><svg class="icon icon-user">
                  <use xlink:href="{{asset("img/sprite.svg#icon-user")}}"></use>
                </svg>
              </a>
            </div>
          @endguest
        </div>
      </div>
      <div class="header__menu menu js-menu">
        <div class="menu__center center">
          <form class="menu__search search">
            <div class="search__wrap">
              <input class="search__input" type="text" placeholder="Search" />
            </div>
            <button class="search__btn">
              <svg class="icon icon-search">
                <use xlink:href="{{asset("img/sprite.svg#icon-search")}}"></use>
              </svg>
            </button>
          </form>

          
          <div class="menu__container">
            <div class="menu__list js-menu-list">
              <a class="menu__item active" href="{{url('/')}}">Home</a>
              <div class="menu__item js-menu-item">
                <div class="menu__head js-menu-head">
                  Categories<svg class="icon icon-arrow-next">
                    <use xlink:href="{{asset("img/sprite.svg#icon-arrow-next")}}"></use>
                  </svg>
                </div>
                <div class="menu__body js-menu-body">
                  <button class="menu__close js-menu-close">
                    <svg class="icon icon-close">
                      <use xlink:href="{{asset("img/sprite.svg#icon-close")}}"></use>
                    </svg></button><button class="menu__back js-menu-back">
                    <svg class="icon icon-arrow-prev">
                      <use xlink:href="{{asset("img/sprite.svg#icon-arrow-prev")}}"></use>
                    </svg>
                  </button>
                    <div class="menu__group">
                      @foreach ( $cats as $cat)
                        <a class="menu__link" href="{{url("/categories/{$cat->id}")}}">{{$cat->name}}</a>
                      @endforeach
                      
                    </div>
                </div>
              </div>
              <a class="menu__item" href="#">Blog</a><a class="menu__item" href="about-us.html">About</a><a
                class="menu__item" href="contacts.html">Contact</a>
            </div>
          </div>
          <a class="menu__btn btn btn_green btn_wide" href="login.html">Login</a>
          <div class="menu__social">
            <a class="menu__link" href="https://www.instagram.com/ui8net/" target="_blank"><svg
                class="icon icon-instagram">
                <use xlink:href="img/sprite.svg#icon-instagram"></use>
              </svg></a><a class="menu__link" href="https://twitter.com/ui8" target="_blank"><svg
                class="icon icon-twitter">
                <use xlink:href="img/sprite.svg#icon-twitter"></use>
              </svg></a><a class="menu__link" href="https://www.facebook.com/ui8.net/" target="_blank"><svg
                class="icon icon-facebook">
                <use xlink:href="{{asset("img/sprite.svg#icon-facebook")}}"></use>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </header>

    @yield('content')
    <footer class="footer">
      <div class="footer__center center">
        <div class="footer__row">
          <div class="footer__col">
            <a class="footer__logo" href="index.html"><img class="footer__pic footer__pic_black-desktop"
                src="{{asset("img/logo_alheba.png")}}" alt="" /><img class="footer__pic footer__pic_white-desktop"
                src="{{asset("img/logo_alheba.png")}}" alt="" /><img class="footer__pic footer__pic_black-mobile"
                src="{{asset("img/logo_alheba.png")}}" alt="" /><img class="footer__pic footer__pic_white-mobile"
                src="{{asset("img/logo_alheba.png")}}" alt="" /></a>
            <div class="footer__copyright">©
              <script>document.write(new Date().getFullYear());</script> - All rights reserved
            </div>
            <div class="footer__social social">
              <a class="social__link" href="https://www.instagram.com/ui8net/" target="_blank"><svg
                  class="icon icon-instagram">
                  <use xlink:href="{{asset("img/sprite.svg#icon-instagram")}}"></use>
                </svg></a><a class="social__link" href="https://twitter.com/ui8" target="_blank"><svg
                  class="icon icon-twitter">
                  <use xlink:href="{{asset("img/sprite.svg#icon-twitter")}}"></use>
                </svg></a><a class="social__link" href="https://www.facebook.com/ui8.net/" target="_blank"><svg
                  class="icon icon-facebook">
                  <use xlink:href="{{asset("img/sprite.svg#icon-facebook")}}"></use>
                </svg></a>
            </div>
            <label class="switch js-switch-bg"><input class="switch__input" type="checkbox" /><span
                class="switch__in"><span class="switch__tick"><img class="switch__pic switch__pic_moon"
                    src="img/moon.svg" alt="" /><img class="switch__pic switch__pic_sun" src="img/sun.svg"
                    alt="" /></span></span></label>
          </div>
          <div class="footer__col">
            <div class="footer__category">Categories</div>
            <div class="footer__menu">
              @foreach ($cats as $cat)
                <a class="footer__link" href="{{url("categories/{$cat->id}")}}">{{$cat->name}}</a>
              @endforeach
            </div>
          </div>
          <div class="footer__col">
            <div class="footer__category">Legal</div>
            <div class="footer__menu">
              <a class="footer__link" href="legal-page.html">Terms of Service</a><a class="footer__link"
                href="legal-page.html">Privacy Policy</a><a class="footer__link" href="legal-page.html">Returns
                Policy</a><a class="footer__link" href="legal-page.html">Shipping</a><a class="footer__link"
                href="legal-page.html">Data Protection</a>
            </div>
          </div>
          <div class="footer__col">
            <div class="footer__category">Company</div>
            <div class="footer__menu">
              <a class="footer__link" href="{{url('/about-us')}}">About</a><a class="footer__link" href="{{url('faq')}}">Faq</a><a
                class="footer__link" href="{{url('/contact')}}>Contact</a><a class="footer__link"
                href="careers-page.html">Careers</a><a class="footer__link" href="#">Vision</a><a class="footer__link"
                href="#">Culture</a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div><!-- scripts-->
  <script src="{{url("js/app.js")}}"></script>
  <script src="{{url("js/common.js")}}"></script>
  @yield('scripts')
</body>

</html>