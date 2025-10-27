@extends('layouts.app')

@section('content')
    <!-- Main Slider -->
    @include('partials.slider')

    <!-- Features -->
    @include('partials.features')

    <!-- Categories -->
    @include('partials.categories')

    <!-- Featured Products -->
    @include('partials.featured-products')

    <!-- Recent Products -->
    @include('partials.recent-products')
@endsection
