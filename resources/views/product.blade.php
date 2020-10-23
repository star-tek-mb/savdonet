@extends('layouts.app')

@section('title', $product->title)

@section('content')

<div class="container mb-4">
    @if (session('status'))
    <div class="alert alert-info" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <h1 class="mb-4">{{ $product->title }}</h1>
    <div class="row">
        <div class="col-sm-12 col-lg-6 text-center my-auto no-float">
            <div class="carousel slide" id="carousel">
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
                    <div id="variation-photo" class="carousel-item">
                        <img src="{{ Storage::url($product->variations[0]->photo_url) }}" class="d-block w-100">
                    </div>
                </div>
                <!--
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">{{ __("Previous") }}</span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">{{ __("Next") }}</span>
                </a>-->
            </div>
        </div>
        <div class="col-sm-12 col-lg-6 mt-4">
            <h4>{{ __('Category')}}</h4>
            <p>{{ $product->category->full_name }}</p>
            <h4 class="mt-4">{{ __("Description") }}</h4>
            <p>{!! $product->description !!}</p>
            <div id="product-chooser">
            </div>
            @if (count($product->options) == 0)
            <h4>{{ __('Make an Order') }}</h4>
            <div class="row">
                <p class="col-12 h4"><b>{{ __("Stock") }}</b>:
                    {{ $product->variations[0]->stock }}</p>
                <p class="col-12 h4 font-weight-bold"><b>{{ __("Price") }}</b>:
                    @include('product-variation-price', ['variation' => $product->variations[0]])
                </p>
                <div class="col-12 my-2">
                    <input type="number" id="variation{{ $product->variations[0]->id }}" class="form-control" value="1">
                </div>
                <div class="col-12 btn-group btn-group-justified">
                    <a class="btn btn-primary py-2 m-1
                        onclick="event.preventDefault(); window.location = '{{ route('cart.store', $product->variations[0]->id) }}?order&qty=' + $('#variation{{ $product->variations[0]->id }}').val();"
                        href="{{ route('cart.store', $product->variations[0]->id) }}">{{ __("Order") }}</a>
                    <a class="btn btn-primary py-2 m-1"
                        onclick="event.preventDefault(); window.location = '{{ route('cart.store', $product->variations[0]->id) }}?qty=' + $('#variation{{ $product->variations[0]->id }}').val();"
                        href="{{ route('cart.store', $product->variations[0]->id) }}"><i
                            class="fas fa-shopping-cart"></i></a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('js')
@if (count($product->options) == 0)
<script src="{{ asset('js/app.js') }}"></script>
@else
<script>
window.product_id = {{ $product->id }};
</script>
<script src="{{ asset('js/product-chooser.js') }}"></script>
@endif
@endpush