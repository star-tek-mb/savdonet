@php
$sale_price = $product->sale_price;
$price = $product->price;
@endphp
<div class="my-1 h3 font-weight-bold">
@if ($sale_price[0] != $price[0] || $sale_price[1] != $price[1])

@if ($sale_price[0] == $sale_price[1])
<del>{{ Str::currency($price[0]) }} {{ __('currency') }}</del>
<br>
<span>{{ Str::currency($sale_price[0]) }} {{ __('currency') }}</span>
@else
<del>{{ Str::currency($price[0]) }} - {{ Str::currency($price[1]) }} {{ __('currency') }}</del>
<br>
<span>{{ Str::currency($sale_price[0]) }} - {{ Str::currency($sale_price[1]) }} {{ __('currency') }}</span>
@endif

@else

@if ($price[0] == $price[1])
<span>{{ Str::currency($price[0]) }} {{ __('currency') }}</span>
@else
<span>{{ Str::currency($price[0]) }} - {{ Str::currency($price[1]) }} {{ __('currency') }}</span>
@endif
</div>
@endif