@extends('layouts.app')

@section('title', $page->title)

@section('content')

<div class="container">
{!! $page->description !!}
</div>

@endsection

@push('js')
<script src="{{ asset('js/app.js') }}" defer></script>
@endpush