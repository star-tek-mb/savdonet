@extends('layouts.app')

@section('title', $product->title)

@section('content')

<div class="container">
    @if (session('status'))
    <div class="alert alert-info" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <h1 class="mb-4">{{ $product->title }}</h1>
    <div class="row">
        <div class="col-sm-12 col-lg-6 text-center my-auto no-float">
            <div class="carousel slide" id="carousel" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel" data-slide-to="0" class="active"></li>
                    @foreach($product->media ?? array() as $media)
                    <li data-target="#carousel" data-slide-to="{{ $loop->index+1 }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ Storage::url($product->variations[0]->photo_url) }}" class="d-block w-100">
                    </div>
                    @foreach($product->media ?? array() as $media)
                    <div class="carousel-item">
                        <img src="{{ Storage::url($media) }}" class="d-block w-100">
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">{{ __("Previous") }}</span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">{{ __("Next") }}</span>
                </a>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6 mt-4">
            <h4>{{ __('Category')}}</h4>
            <p>@php
                $par = $product->category->parent;
                $parents = array();
                while ($par) {
                array_push($parents, $par);
                $par = $par->parent;
                }
                $parents = array_reverse($parents);
                @endphp
                @foreach ($parents as $parent)
                {{ $parent->title }} -
                @endforeach
                {{ $product->category->title }}
            </p>
            <h4 class="mt-4">{{ __("Description") }}</h4>
            <p>{{ $product->description }}</p>
        </div>
    </div>
    @if (count($product->options) > 0)
    <div class="text-center mx-auto pt-4">
        <h1>{{ __("Variations") }}</h1>
        @foreach ($product->variations as $variation)
        <div class="row mx-auto">
            <div class="col-sm-12 col-md-4 my-sm-4">
                <img src="{{ Storage::url($variation->photo_url) }}" class="mx-auto img-fluid"
                    alt="{{ $product->title }}" />
            </div>
            <div class="col-sm-6 col-md-4 my-auto">
                <p><b>{{ __("Stock") }}</b>: {{ $variation->stock }}</p>
                <p><b>{{ __("Price") }}</b>: {{ $variation->price }} сум</p>
                @foreach ($variation->values as $variation_value_id)
                @foreach ($values as $value)
                @if ($value->id == $variation_value_id)
                <p><b>{{ $value->option->title }}</b>: {{ $value->title }}</p>
                @endif
                @endforeach
                @endforeach
            </div>
            <div class="col-sm-6 col-md-4 my-auto">
                <div class="col text-right my-2">
                    <input type="number" id="variation{{ $variation->id }}" class="form-control" value="1">
                </div>
                <div class="col my-2">
                    <a class="btn btn-primary w-100"
                        onclick="event.preventDefault(); window.location = '{{ route('cart.store', $variation->id) }}?qty=' + $('#variation{{ $variation->id }}').val();"
                        href="{{ route('cart.store', $variation->id) }}">{{ __("To Cart") }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="row my-4">
        <p class="col-4 my-auto text-right"><b>{{ __("Stock") }}</b>:
            {{ $product->variations[0]->stock }}<br><b>{{ __("Price") }}</b>: {{ $product->variations[0]->price }} сум
        </p>
        <div class="col-4 text-right my-2">
            <input type="number" id="variation{{ $product->variations[0]->id }}" class="form-control" value="1">
        </div>
        <div class="col-4 my-2">
            <a class="btn btn-primary"
                onclick="event.preventDefault(); window.location = '{{ route('cart.store', $product->variations[0]->id) }}?qty=' + $('#variation{{ $product->variations[0]->id }}').val();"
                href="{{ route('cart.store', $product->variations[0]->id) }}">{{ __("To Cart") }}</a>
        </div>
    </div>
    @endif
</div>

@endsection

@push('js')
<script src="{{ asset('js/app.js') }}" defer></script>
@endpush