@extends('layouts.backend')

@section('title', __('Order') . ' №' . $order->id)

@section('content')
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Order Details') }}</h3>
        </div>
        <div class="card-body">
            <p><b>{{ __('Full name') }}</b>: {{ $order->name }}</p>
            <p><b>{{ __('E-Mail Address') }}</b>: {{ $order->email ?? __('No') }}</p>
            <p><b>{{ __('Phone') }}</b>: {{ $order->phone }}</p>
            <p><b>{{ __('Region') }}</b>: {{ __($order->region_city) }}</p>
            <p><b>{{ __('Address') }}</b>: {{ $order->address }}</p>
            <p><b>{{ __('Comment') }}</b>: {{ $order->comment ?? __('No') }}</p>
            <p><b>{{ __('Status') }}</b>: {{ __($order->status) }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Order Items') }}</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table">
                <thead class="thead-light">
                    <th style="width: 55%;">{{ __('Product') }}</th>
                    <th style="width: 15%;">{{ __('Quantity') }}</th>
                    <th style="width: 15%;">{{ __('Price') }}</th>
                    <th style="width: 15%;">{{ __('Total') }}</th>
                </thead>
                <tbody>
                    @php $total = $order->delivery_price; @endphp
                    @foreach($order->products as $order_product)
                    <tr>
                        <td>{{ $order_product->item->product->title }}
                            <span>{{ $order_product->item->full_name ? '(' . $order_product->item->full_name . ')' : '' }}</span>
                        </td>
                        <td>
                            {{ $order_product->quantity }}
                        </td>
                        <td>{{ $order_product->item->price }} сум</td>
                        <td>{{ $order_product->item->price * $order_product->quantity }} сум</td>
                    </tr>
                    @php $total += $order_product->item->price * $order_product->quantity; @endphp
                    @endforeach
                    <tr>
                        <td colspan="3">{{ __('delivery_price') }}</td>
                        <td>{{ $order->delivery_price }} сум</td>
                    </tr>
                    <tr>
                        <td colspan="3">{{ __('Total') }}</td>
                        <td>{{ $total }} сум</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection