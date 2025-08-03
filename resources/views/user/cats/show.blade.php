@extends('layout.layout')
@section('title')
  Categories
@endsection
@section('content')
    @section('extra-bread')
      <li class="breadcrumbs__item">{{$cat->name}}</li>
    @endsection
    @include('layout.breadcrumbs')
    <div class="products products_full section">
      <div class="products__center center">
        <div class="products__stage stage">-{{$cat->name}} Products</div>
        <h2 class="products__title title title_mb-lg">
          Explore the {{$cat->name}} <br />Products
        </h2>
        <div class="filters js-filters">
          <div class="filters__sorting">
            <div class="filters__open js-filters-open">Filter By</div>
            <div class="filters__wrap js-filters-wrap">
              <div class="filters__drop drop js-drop">
                <div class="drop__head js-drop-head">Color</div>
                <div class="drop__body js-drop-body">
                  @foreach ($prods->unique('color_id') as $prod)
                    <a class="drop__link js-drop-link" href="{{ url("categories/$cat->id/color/{$prod->color_id}") }}">{{$prod->color->name}}</a>
                  @endforeach
                </div>
              </div>
              <div class="filters__drop drop js-drop">
                <div class="drop__head js-drop-head">Category</div>
                <div class="drop__body js-drop-body">
                  @foreach ( $cats as $c)
                    <a class="drop__link js-drop-link" href="{{url("categories/$c->id")}}">{{$c->name}}</a>
                  @endforeach
                </div>
              </div>
              <div class="filters__drop drop js-drop">
                <div class="drop__head js-drop-head">Price Range</div>
                <div class="drop__body js-drop-body">
                  <a class="drop__link js-drop-link" href="{{url("categories/{$cat->id}/50-0")}}">$0 - $50</a>
                  <a class="drop__link js-drop-link"href="{{url("categories/{$cat->id}/100-50")}}">$50 - $100</a>
                  <a class="drop__link js-drop-link" href="{{url("categories/{$cat->id}/more-100")}}">$100 - max</a>
                </div>
              </div>
            </div>
            <div class="filters__field field">
              <form method="GET" action="{{ route('categories.sort', ['id' => $cat->id]) }}">
                <div class="field__wrap">
                  <select class="field__select" name="sort" onchange="this.form.submit()">
                    <option value="">Sort By</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A to Z</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z to A</option>
                  </select>
                </div>
              </form>

            </div>
          </div>
          <div class="filters__tags">
            @if (isset($range))
              @if (str_starts_with($range,"more-"))
              <div class="filters__tag">
                ${{ str_replace('more-', '', $range) }} - max<button class="filters__remove"></button>
              </div>
              @elseif (str_contains($range, '-'))
                @php
                  [$max, $min] = explode('-', $range);
                @endphp
                <div class="filters__tag">
                ${{ $min }} - ${{ $max }}<button class="filters__remove"></button>
              </div>  
               @endif
            @endif
            <div class="filters__tag">
              {{$cat->name}}<button class="filters__remove"></button>
            </div>
            @if (isset($color))
            <div class="filters__tag">
              {{$prod->color->name}}<button class="filters__remove"></button>
            </div>
            @endif
          </div>
        </div>
        <div class="products__list">
          @foreach ($prods as $prod )
            <div class="product">
              @if ($prod->offer >0)
                <div class="product__sale">{{$prod ->offer}} % OFF</div>
              @endif
              <div class="product__view">
                <a class="product__preview" href="{{"/products/{$prod->id}"}}">
                <img class="product__pic"src="{{asset("img/products/product-pic-". $loop->iteration . ".png")}}" alt="" />
                </a><a class="product__btn btn btn_green" href="cart.html">Add to Cart</a>
              </div>
              <a class="product__name" href="product.html">{{$prod->name}}</a>
              <div class="product__details">
                <div class="product__category yellow">{{$prod->category->name}}</div>
                <div class="product__price">
                  <span class="product__old">{{$prod->price}}$</span>
                  <span class="product__actual">{{$prod->price - $prod->offer}}$</span>
                </div>
              </div>
            </div>
          @endforeach
        
        </div>
      </div>
    </div>
    @include('layout.newsletter')
@endsection
@section('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.js-drop-head').forEach(function(head) {
        head.addEventListener('click', function() {
        const parent = head.closest('.drop');
        parent.classList.toggle('open');
    });
  });
});
</script>
<script>
    function sortProducts(select) {
    const value = select.value;
    if (value) {
      // Redirect with query parameter
      window.location.href = `?sort=${value}`;
    }
  }
    </script>

    
@endsection