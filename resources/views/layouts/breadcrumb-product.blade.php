@if (Route::currentRouteName() == 'product.show' && isset($product))
@include('layouts.breadcrumb-category', ['category' => $product->category])
@if (Request::route('id')==$product->id)
<li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
@else
<li class="breadcrumb-item"><a href="{{ route('product.show', $product->id) }}">{{ $product->title }}</a></li>
@endif
@endif