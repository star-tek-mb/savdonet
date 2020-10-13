@extends('layouts.app')

@section('title', $category->title)

@section('content')

<div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <h1 class="py-4">{{ $category->title }}</h1>
    @if (count($products) == 0)
    <p class="h2">{{ __("Category is empty!") }}</p>
    @else
    <div class="row">
        @foreach ($products as $product)
        <div class="col-12 col-md-6 col-lg-4 py-2">
            <div class="card h-100">
                <img src="{{ Storage::url($product->variations[0]->photo_url) }}" class="card-img-top"
                    alt="{{ $product->title }}" />
                <div class="card-body">
                    <h5 class="card-title no-letter-spacing">
                        {{ $product->title }}<span class="text-danger float-right">{{ $product->variations[0]->price }}
                            сум</span>
                    </h5>
                    <p>{{ \Illuminate\Support\Str::limit($product->description, 200) }}</p>
                </div>
                <div class="mb-4 mr-4 text-right">
                    @if (count($product->variations) == 1)
                    <a class="btn btn-primary"
                        href="{{ route('cart.store', $product->variations[0]->id) }}">{{ __("To Cart") }}</a>
                    @endif
                    <a class="btn btn-info" href="{{ route('product.show', $product->id) }}">{{ __("More") }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mx-auto my-2">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection

@push('js')
<script src="{{ asset('js/pace.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
@endpush

@push('css')
<link href="{{ asset('css/pace.min.css') }}" rel="stylesheet">
@endpush