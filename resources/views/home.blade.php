@extends('layouts.app')

@section('title', __('Home'))

@section('content')

@if (session('status'))
<div class="container">
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
</div>
@endif
<div id="home">
</div>

@endsection

@push('js')
<script src="{{ asset('js/pace.min.js') }}"></script>
<script src="{{ asset('js/home.js') }}" defer></script>
@endpush

@push('css')
<link href="{{ asset('css/pace.min.css') }}" rel="stylesheet">
@endpush