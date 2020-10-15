@extends('layouts.backend')

@section('title', __('Products'))

@section('content')

<div class="container-fluid">

    <table id="products" class="table table-bordered dt-responsive dt-head-nowrap" style="width:100%">
        <thead>
            <th>{{ __('Photo') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Category') }}</th>
            <th>{{ __('Supplier') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Stock') }}</th>
            <th>{{ __('Action') }}</th>
        </thead>
        <tbody>
        </tbody>
    </table>

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
                name: 'title'
            },
            {
                data: 'category',
                name: 'category'
            },
            {
                data: 'supplier',
                name: 'supplier'
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