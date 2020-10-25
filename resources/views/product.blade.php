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
            <div class="row">
                <div class="col-12">
                    <img id="variation-photo" src="{{ Storage::url($product->variations[0]->photo_url) }}"
                        class="d-block w-100">
                </div>
                <div class="col-12">
                <div class="row justify-content-start px-3 my-1">
                    <div class="col-3 p-0">
                        <img src="{{ Storage::url($product->variations[0]->photo_url) }}"
                            class="img-thumbnail active w-100">
                    </div>
                    @foreach($product->media ?? array() as $media)
                    <div class="col-3 p-0">
                        <img src="{{ Storage::url($media) }}" class="img-thumbnail w-100">
                    </div>
                    @endforeach
                    </div>
                </div>
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
                        href="{{ route('cart.store', $product->variations[0]->id) }}"><i class="fas fa-shopping-cart"></i></a>
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
<script>
$(document).ready(function() {
    $('.img-thumbnail').on('click', function() {
        $('.img-thumbnail').removeClass('active');
        $(this).addClass('active');
        $('#variation-photo').attr('src', $(this).attr('src'));
    });
});
</script>
@endpush

@push('css')
<style>
.img-thumbnail {
    padding: 0 !important;
    border-width: 3px;
}
.img-thumbnail.active {
    border-color: orange;
}
</style>
@endpush