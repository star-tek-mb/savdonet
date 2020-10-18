@extends('layouts.backend')

@section('title', __('Supplier') . ' ' . $supplier->shop_name)

@section('content')
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Supplier') }}</h3>
            <div class="card-tools">
                <a href="{{ route('backend.suppliers.edit', $supplier->id) }}" class="btn btn-tool bg-green"><i
                        class="fas fa-edit"></i></a>
            </div>
        </div>
        <div class="card-body">
            <p><b>{{ __('Full name') }}</b>: {{ $supplier->name }}</p>
            <p><b>{{ __('Shop name') }}</b>: {{ $supplier->shop_name }}</p>
            <p><b>{{ __('Phone') }}</b>: {{ $supplier->phone }}</p>
            <p><b>{{ __('Address') }}</b>: {{ $supplier->address }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Products') }}</h3>
        </div>
        <div class="card-body">
            <table id="products" class="table table-bordered dt-responsive dt-head-nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('Full name') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Stock') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplier->products as $product)
                    @foreach ($product->variations as $variation)
                    <tr>
                        <td>{{ $variation->product->title }}
                            {{ $variation->full_name ?  '(' . $variation->full_name . ')' : '' }}</td>
                        <td>{{ $variation->product->category->full_name }}</td>
                        <td>{{ $variation->stock }}</td>
                        <td>{{ $variation->price }}</td>
                        <td>
                            <a href="{{ route('backend.products.edit', $variation->product_id) }}"
                                class="btn btn-tool text-white bg-blue"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    $('#products').DataTable({
        responsive: true,
        language: window.DataTableLanguage,
        columns: [
            null,
            null,
            null,
            null,
            {
                width: '1%',
                orderable: false,
                searchable: false,
                className: 'dt-body-nowrap'
            },
        ]
    });
});
</script>
@endpush

@push('css')
<style>
.dt-body-nowrap {
    white-space: nowrap;
}

table.dt-head-nowrap thead {
    white-space: nowrap;
}
</style>
@endpush