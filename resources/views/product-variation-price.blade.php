@if ($variation->price_with_sale == $variation->price)
<span>{{ $variation->price }} {{ __('currency') }}</span>
@else
<del>{{ $variation->price }} {{ __('currency') }}</del> <span>{{ $variation->price_with_sale }} {{ __('currency') }}</span>
@endif