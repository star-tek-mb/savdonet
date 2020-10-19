@if ($variation->price_with_sale == $variation->price)
<span>{{ Str::currency($variation->price) }} {{ __('currency') }}</span>
@else
<del>{{ Str::currency($variation->price) }} {{ __('currency') }}</del> <span>{{ Str::currency($variation->price_with_sale) }} {{ __('currency') }}</span>
@endif