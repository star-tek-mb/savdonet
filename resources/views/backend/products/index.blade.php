@extends('layouts.backend')

@section('title', __('Products'))

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Categories') }}</h3>
            <div class="card-tools">
                <a class="btn btn-tool bg-green" href="{{ route('backend.categories.create') }}"><i
                        class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="card-body">
            <table id="products" class="table table-bordered dt-responsive dt-head-nowrap" style="width:100%">
                <thead>
                    <th>{{ __('Photo') }}</th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Supplier') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Stock') }}</th>
                    <th>{{ __('Views') }}</th>
                    <th>{{ __('Action') }}</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
$(document).ready(function() {
    var table = $('#products').DataTable({
        language: window.DataTableLanguage,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('backend.products.index') }}",
        columns: [{
                data: 'image',
                name: 'image',
                width: '15%',
                orderable: false,
                searchable: false
            },
            {
                data: 'title',
                name: 'product.title'
            },
            {
                data: 'category',
                name: 'product.category.title',
            },
            {
                data: 'supplier',
                name: 'product.supplier.shop_name',
            },
            {
                data: 'price',
                name: 'price'
            },
            {
                data: 'stock',
                name: 'stock'
            },
            {
                data: 'views',
                name: 'product.views'
            },
            {
                data: 'action',
                name: 'action',
                className: 'dt-body-nowrap',
                orderable: false,
                searchable: false
            }
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