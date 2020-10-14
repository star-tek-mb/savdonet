@extends('layouts.backend')

@section('title', __('Suppliers'))

@section('content')
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Suppliers') }}</h3>
            <div class="card-tools">
                <a class="btn btn-tool bg-green" href="{{ route('backend.suppliers.create') }}"><i
                        class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="card-body">
            <table id="suppliers" class="table table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('Full name') }}</th>
                        <th>{{ __('Shop name') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->shop_name }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>{{ $supplier->phone }}</td>
                        <td>
                            <a href="{{ route('backend.suppliers.edit', $supplier->id) }}"
                                class="btn btn-tool text-white bg-green"><i class="fas fa-edit"></i></a>
                            <form class="d-none" action="{{ route('backend.suppliers.destroy', $supplier->id) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                            </form>
                            <a class="btn btn-tool bg-red" onclick="event.preventDefault(); $(this).prev().submit();"><i
                                    class="fas fa-trash"></i></a>
                        </td>
                    </tr>
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
    $('#suppliers').DataTable({
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
                searchable: false
            },
        ]
    });
});
</script>
@endpush