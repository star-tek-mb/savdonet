@php
$sale_price = $product->sale_price;
$price = $product->price;
@endphp

@if ($sale_price)

@if ($sale_price[0] == $sale_price[1])
<del class="text-danger float-right">{{ $price[0] }} {{ __('currency') }}</del>
<span class="text-danger float-right">{{ $sale_price[0] }} {{ __('currency') }}</span>
@else
<del class="text-danger float-right">{{ $price[0] }} - {{ $price[1] }} {{ __('currency') }}</del>
<span class="text-danger float-right">{{ $sale_price[0] }} - {{ $sale_price[1] }} {{ __('currency') }}</span>
@endif

@else

@if ($price[0] == $price[1])
<span class="text-danger float-right">{{ $price[0] }} {{ __('currency') }}</span>
@else
<span class="text-danger float-right">{{ $price[0] }} - {{ $price[1] }} {{ __('currency') }}</span>
@endif

@endif