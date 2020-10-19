@extends('layouts.app')

@section('title', __('Search'))

@section('content')

<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <h3>{{ __('Search error') }}:</h3>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h1 class="mb-4">{{ __('Search') }} - {{ __('found_matches', ['value' => count($results)]) }}</h1>
    @foreach ($results as $result)
    <div class="row mb-4">
        <div class="col-3">
            <img src="{{ Storage::url($result->variations[0]->photo_url) }}" class="img-fluid"
                alt="{{ $result->title }}" />
        </div>
        <div class="col-9">
            <h2><a href="{{ route('product.show', $result->id) }}">{{ $result->title }}</a></h2>
            <p>{{ Str::limit(strip_tags($result->description), 200) }}</p>
        </div>
    </div>
    @endforeach
    {{ $results->appends(request()->input())->links() }}
</div>

@endsection

@push('js')
<script src="{{ asset('js/app.js') }}" defer></script>
@endpush