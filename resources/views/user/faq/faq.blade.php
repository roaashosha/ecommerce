@extends('layout.layout')
@section('title')
  Frequantly Asked Questions
@endsection
@section('content')
    @section('extra-bread')
      <li class="breadcrumbs__item">Frequantly Asked Questions</li>
    @endsection
    @include('layout.breadcrumbs')
    {!! $page->content !!}

    @include('layout.newsletter')
@endsection
