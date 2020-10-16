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
            <div class="card-tools">
                <a href="{{ route('backend.orders.edit', $order->id) }}" class="btn btn-tool bg-green"><i class="fas fa-pen"></i></a>
            </div>
        </div>
        <div class="card-body">
            <p><b>{{ __('Full name') }}</b>: {{ $order->name }}</p>
            <p><b>{{ __('E-Mail Address') }}</b>: {{ $order->email ?? __('No') }}</p>
            <p><b>{{ __('Phone') }}</b>: {{ $order->phone }}</p>
            <p><b>{{ __('Region') }}</b>: {{ __($order->region) ?? __('No') }}</p>
            <p><b>{{ __('City') }}</b>: {{ $order->city ?? __('No') }}</p>
            <p><b>{{ __('Address') }}</b>: {{ $order->address ?? __('No') }}</p>
            <p><b>{{ __('Comment') }}</b>: {{ $order->comment ?? __('No') }}</p>
            <p><b>{{ __('Shipping Method') }}</b>: {{ __($order->delivery) ?? __('No') }}</p>
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
                    @foreach($order->products as $order_product)
                    <tr>
                        <td>
                        @if (isset($order_product->item->product))
                        {{ $order_product->item->product->title }}
                            <span>{{ $order_product->item->full_name ? '(' . $order_product->item->full_name . ')' : '' }}</span>
                        @else
                        {{ __('No') }}
                        @endif
                        </td>
                        <td>
                            {{ $order_product->quantity }}
                        </td>
                        <td>{{ $order_product->price }} {{ __('currency') }}</td>
                        <td>{{ $order_product->price * $order_product->quantity }} {{ __('currency') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">{{ __('Delivery Price') }}</td>
                        <td>{{ $order->delivery_price }} {{ __('currency') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">{{ __('Total') }}</td>
                        <td>{{ $order->total }} {{ __('currency') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection