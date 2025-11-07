@extends('client.layouts.app')

@section('content')
    <!-- Main Slider -->
    @include('client.partials.slider')

    <!-- Features -->
    @include('client.partials.features')

    <!-- Categories -->
    @include('client.partials.categories')

    <!-- Featured Products -->
    @include('client.partials.featured-products')

    <!-- Recent Products -->
    @include('client.partials.recent-products')
@endsection
