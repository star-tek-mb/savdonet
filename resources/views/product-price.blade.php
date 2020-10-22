@php
$sale_price = $product->sale_price;
$price = $product->price;
@endphp

@if ($sale_price[0] != $price[0] || $sale_price[1] != $price[1])

@if ($sale_price[0] == $sale_price[1])
<del class="h4 font-weight-bold">{{ Str::currency($price[0]) }} {{ __('currency') }}</del>
<br>
<span class="h4 font-weight-bold">{{ Str::currency($sale_price[0]) }} {{ __('currency') }}</span>
@else
<del class="h4 font-weight-bold">{{ Str::currency($price[0]) }} - {{ Str::currency($price[1]) }} {{ __('currency') }}</del>
<br>
<span class="h4 font-weight-bold">{{ Str::currency($sale_price[0]) }} - {{ Str::currency($sale_price[1]) }} {{ __('currency') }}</span>
@endif

@else

@if ($price[0] == $price[1])
<span class="h4 font-weight-bold">{{ Str::currency($price[0]) }} {{ __('currency') }}</span>
@else
<span class="h4 font-weight-bold">{{ Str::currency($price[0]) }} - {{ Str::currency($price[1]) }} {{ __('currency') }}</span>
@endif

@endif