@extends('admin.layouts.app')

@section('title', 'Dashboard - SB Admin')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
