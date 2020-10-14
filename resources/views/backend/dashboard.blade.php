@extends('layouts.backend')

@section('title', __('Dashboard'))

@section('content')
<div class="container-fluid pb-4">
    <div class="row">
        <div class="col-6 col-lg-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $products_count }}</h3>
                    <p>{{ __('Products') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tshirt"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $orders_count }}</h3>
                    <p>{{ __('Orders') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $categories_count }}</h3>
                    <p>{{ __('Categories') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-folder"></i>
                </div>
            </div>
        </div>
    </div>
    <h3 class="my-2">{{ __('Orders notification') }}</h3>
    <table id="orders" class="table table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>{{ __('Full name') }}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('Region') }}</th>
                <th>{{ __('Address') }}</th>
                <th>{{ __('Total') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders_notification as $order)
        @php $total = $order->delivery_price;
        foreach ($order->products as $order_product) {
            $total += $order_product->price * $order_product->quantity;
        }
        @endphp
        <tr>
            <td>{{ $order->name }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ __($order->region_city) }}</td>
            <td>{{ $order->address }}</td>
            <td>{{ $total }} сум</td>
            <td>
                @include('backend.orders.datatables-action')
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <h3 class="my-2">{{ __('Stocks notification') }}</h3>
    <table id="stocks" class="table table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Stock') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($stocks_notification as $variation)
        <tr>
            <td>
                {{ $variation->product->title }} {{ $variation->full_name ? '(' . $variation->full_name . ')' : '' }}
            </td>
            <td>{{ $variation->price }} сум</td>
            <td>{{ $variation->stock }}</td>
            <td>
                @include('backend.products.datatables-action', ['product' => $variation->product, 'delete' => false])
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    $('#orders').DataTable({
        responsive: true,
        paging: false,
        ordering: false,
        info: false,
        searching: false,
        language: window.DataTableLanguage,
        columns: [
            null,
            null,
            null,
            null,
            null,
            {
                "width": "10%"
            },
        ]
    });
    $('#stocks').DataTable({
        responsive: true,
        paging: false,
        ordering: false,
        info: false,
        searching: false,
        language: window.DataTableLanguage,
        columns: [
            {
                "width": "70%"
            },
            {
                "width": "10%"
            },
            {
                "width": "10%"
            },
            {
                "width": "10%"
            },
        ]
    });
});
</script>
@endpush