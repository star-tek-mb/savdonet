@extends('layouts.backend')

@section('title', __('Orders'))

@section('content')

<div class="container-fluid">

    <table id="orders" class="table table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
            <th>№</th>
            <th>{{ __('Full name') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Order date') }}</th>
            <th>{{ __('Phone') }}</th>
            <th>{{ __('Region') }}</th>
            <th>{{ __('Address') }}</th>
            <th>{{ __('Total') }}</th>
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
    var table = $('#orders').DataTable({
        language: window.DataTableLanguage,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('backend.orders.index') }}",
        search: {
            status: "{{ __('created') }}"
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'status',
                name: 'status'
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
                data: 'region_city',
                name: 'region_city'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'total',
                name: 'total'
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