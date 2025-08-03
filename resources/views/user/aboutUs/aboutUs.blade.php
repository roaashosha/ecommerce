@extends('layout.layout')
@section('title')
  About Us
@endsection
@section('content')
    @section('extra-bread')
      <li class="breadcrumbs__item">About Us</li>
    @endsection
    @include('layout.breadcrumbs')
    {!! $page->content !!}

    @include('layout.newsletter')
@endsection