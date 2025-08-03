<div class="breadcrumbs">
      <div class="breadcrumbs__center center">
        <ul class="breadcrumbs__list">
          <li class="breadcrumbs__item">
            <a class="breadcrumbs__link" href="{{url('/')}}">Home Page</a>
          </li>
          <li class="breadcrumbs__item">
            <a class="breadcrumbs__link" href="{{url("categories/1")}}">Navigation</a>
          </li>
          {{-- <li class="breadcrumbs__item">{{$cat->name}}</li> --}}
          @yield('extra-bread')
        </ul>
      </div>
    </div>