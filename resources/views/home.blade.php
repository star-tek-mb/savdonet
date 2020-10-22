@extends('layouts.app')

@section('title', __('Home'))

@section('content')

@if (session('status'))
<div class="container mb-4">
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
</div>
@endif
<div id="home">
</div>

@endsection

@push('js')
<script src="{{ asset('js/home.js') }}" defer></script>
@endpush