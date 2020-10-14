@extends('layouts.app')

@section('title', __('Cart'))

@section('content')

<div class="container">
    @if (session('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
    @endif
</div>

<div class="container">
    <h1 class="h3 py-4">{{ __("Cart") }}</h1>
    @if (count($cart) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <th style="width: 55%;">{{ __('Product') }}</th>
                <th style="width: 20%;">{{ __('Quantity') }}</th>
                <th style="width: 25%;">{{ __('Price') }}</th>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $cartItem)
                <tr>
                    <td>{{ $cartItem['variation']->product->title }}
                        <span>{{ $cartItem['variation']->full_name ? '(' . $cartItem['variation']->full_name . ')' : '' }}</span>
                    </td>
                    <td>
                        {{ $cartItem['quantity'] }}
                        <div class="btn-group float-right">
                            <a href="{{ route('cart.store', ['id' => $cartItem['variation']->id, 'qty' => $cartItem['quantity']+1 ]) }}"
                                class="btn btn-sm btn-success"><i class="fas fa-plus"></i></a>
                            <a href="{{ route('cart.store', ['id' => $cartItem['variation']->id, 'qty' => $cartItem['quantity']-1 ]) }}"
                                class="btn btn-sm btn-danger"><i class="fas fa-minus"></i></a>
                        </div>
                    </td>
                    <td>{{ $cartItem['variation']->price }} сум</td>
                </tr>
                @php $total += $cartItem['variation']->price *$cartItem['quantity']; @endphp
                @endforeach
                <tr>
                    <td>{{ __('Total') }}</td>
                    <td></td>
                    <td>{{ $total }} сум</td>
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
                <select name="region_city" class="form-control">
                    @foreach($regions as $region)
                    <option value="{{ $region }}">{{ __($region) }}</option>
                    @endforeach
                </select>
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
<script src="{{ asset('js/app.js') }}" defer></script>
@endpush