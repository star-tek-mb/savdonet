@extends('layouts.backend')

@section('title', __('Products'))

@section('content')

<div class="container-fluid">

    <table id="products" class="table table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
            <th>{{ __('Photo') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Category') }}</th>
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
    var table = $('#products').on('draw.dt', function() {
        $('.carousel').carousel({
            interval: 2000
        });
    }).DataTable({
        language: window.DataTableLanguage,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('backend.products.index') }}",
        columns: [{
                data: 'image',
                name: 'image',
                width: '20%',
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
                width: '5%',
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>
@endpush