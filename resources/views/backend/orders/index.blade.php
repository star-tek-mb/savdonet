@extends('layouts.backend')

@section('title', __('Orders'))

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
            <ul id="buttons" class="nav nav-pills nav-fill pb-4">
                @foreach ($statuses as $status)
                <li class="nav-item">
                    <a class="nav-link" data-name="{{ $status }}">{{ __($status) }}</a>
                </li>
                @endforeach
            </ul>
            <table id="orders" class="table table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <th>№</th>
                    <th>{{ __('Full name') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Order date') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Region') }}</th>
                    <th>{{ __('City') }}</th>
                    <th>{{ __('Address') }}</th>
                    <th>{{ __('Total') }}</th>
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
    var table = $('#orders').DataTable({
        language: window.DataTableLanguage,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('backend.orders.index') }}",
        columns: [{
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name',
                responsivePriority: 1
            },
            {
                data: 'status',
                name: 'status',
                responsivePriority: 2
            },
            {
                data: 'created_at',
                name: 'created_at',
                render: function(data, type) {
                    var dateParts = data.split("-");
                    var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,
                        2));
                    return jsDate.toLocaleDateString('ru');
                }
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'region',
                name: 'region'
            },
            {
                data: 'city',
                name: 'city'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'total',
                name: 'total',
                responsivePriority: 3
            },
            {
                data: 'action',
                name: 'action',
                width: '5%',
                orderable: false,
                searchable: false,
                responsivePriority: 4,
                targets: -1
            }
        ]
    });
    $('#buttons a').on('click', function() {
        var active = $('#buttons a.active'); 
        if ($(this).is('a.active')) {
            $('#buttons a').removeClass('active');
            table.search('').draw();
        } else {
            $('#buttons a').removeClass('active');
            $(this).addClass('active');
            table.search($(this).data('name')).draw();
        }
    });
});
</script>
@endpush