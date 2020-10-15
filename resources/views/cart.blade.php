@extends('layouts.app')

@section('title', __('Cart'))

@section('content')

<div class="container">
    @if (session('status'))
    <div class="alert alert-info" role="alert">
        {{ session('status') }}
    </div>
    @endif
</div>

<div class="container">
    <h1 class="h3 py-4">{{ __("Cart") }}</h1>
    @if (count($cart) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Total') }}</th>
            </thead>
            <tbody>
                @foreach($cart as $cartItem)
                <tr>
                    <td>{{ $cartItem['variation']->product->title }}
                        <span>{{ $cartItem['variation']->full_name ? '(' . $cartItem['variation']->full_name . ')' : '' }}</span>
                    </td>
                    <td class="my-auto">{{ $cartItem['quantity'] }}
                        <div class="btn-group float-right">
                            <a href="{{ route('cart.store', ['id' => $cartItem['variation']->id, 'qty' => $cartItem['quantity']+1 ]) }}"
                                class="count btn btn-sm btn-success"><i class="fas fa-plus"></i></a>
                            <a href="{{ route('cart.store', ['id' => $cartItem['variation']->id, 'qty' => $cartItem['quantity']-1 ]) }}"
                                class="count btn btn-sm btn-danger"><i class="fas fa-minus"></i></a>
                        </div>
                    </td>
                    <td>{{ $cartItem['variation']->price }} сум</td>
                    <td class="price" data-price="{{ $cartItem['variation']->price * $cartItem['quantity'] }}">
                        {{ $cartItem['variation']->price * $cartItem['quantity'] }} сум
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3">{{ __('Delivery Price') }}</td>
                    <td id="delivery_price"></td>
                </tr>
                <tr>
                    <td colspan="3">{{ __('Total') }}</td>
                    <td id="total_price"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-right">
        <a href="{{ route('cart.clear') }}" class="btn btn-danger">{{ __('Clear cart') }}</a>
    </div>
    <div class="mt-4">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <h3>{{ __('Correct following errors') }}:</h3>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <h1 class="h3 py-4">{{ __('Make an Order') }}</h1>
        <form method="POST" action="{{ route('order') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">{{ __('Shipping Method') }} (<span class="text-danger font-weight-bold">*</span>)</label>
                <select id="delivery_select" name="delivery" class="form-control">
                    @foreach($delivery as $method)
                    <option value="{{ $method }}">{{ __($method) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Full name') }} (<span class="text-danger font-weight-bold">*</span>)</label>
                <input name="fullname" type="text" required class="form-control" placeholder="{{ __('Full name') }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('E-Mail Address') }}</label>
                <input name="email" type="text" class="form-control" placeholder="mail@example.com">
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Phone') }} (<span class="text-danger font-weight-bold">*</span>)</label>
                <input name="phone" type="text" class="form-control" required placeholder="+998XXXXXXXXX">
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Region') }} (<span class="text-danger font-weight-bold">*</span>)</label>
                <select name="region" class="form-control">
                    @foreach($regions as $region)
                    <option value="{{ $region }}">{{ __($region) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('City') }} (<span class="text-danger font-weight-bold">*</span>)</label>
                <input name="city" type="text" class="form-control" required placeholder="{{ __('City') }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Address') }} (<span class="text-danger font-weight-bold">*</span>)</label>
                <input name="address" type="text" class="form-control" required placeholder="{{ __('Street, Apartment') }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Comment') }}</label>
                <textarea name="comment" rows="6" class="form-control"
                    placeholder="{{ __('Location orient, your home time') }}"></textarea>
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="{{ __('Make an Order') }}">
            </div>
        </form>
    </div>
    @else
    <h4>{{ __('Cart is empty!') }}</h4>
    @endif
</div>

@endsection

@push('js')
<script src="{{ asset('js/app.js') }}"></script>
<script>
var prices = {
@foreach ($delivery as $method)
"{{ $method }}": {{ $settings['delivery_price_' . $method] }},
@endforeach
};
function calc() {
    var total = parseInt(prices[$('#delivery_select').val()]);
    $('.price').each(function() {
        total += parseInt($(this).data('price'));
    });
    $('#delivery_price').text(prices[$('#delivery_select').val()] + ' сум');
    $('#total_price').text(total + ' сум');
}
$(document).ready(function() {
    calc();
    $('#delivery_select').on('change', function() {
        calc();
    });
});
</script>
@endpush

@push('css')
<style>
.count {
    padding: 0.5rem !important;
}
</style>
@endpush