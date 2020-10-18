@extends('layouts.backend')

@section('title', __('Pages'))

@section('content')
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Pages') }}</h3>
            <div class="card-tools">
                <a class="btn btn-tool bg-green" href="{{ route('backend.pages.create') }}"><i
                        class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="card-body">
            <table id="pages" class="table table-bordered dt-responsive" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Slug') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                    <tr>
                        <td>{{ $page->number }}</td>
                        <td>{{ $page->slug }}</td>
                        <td>{{ $page->title }}</td>
                        <td>
                            <a href="{{ route('backend.pages.edit', $page->id) }}" class="btn btn-success btn-sm"><i
                                    class="fas fa-edit"></i></a>
                            <form class="d-none" action="{{ route('backend.pages.destroy', $page->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                            </form>
                            <a onclick="event.preventDefault(); if (confirm('{{ __('Are you sure?') }}')) { $(this).prev().submit(); }"
                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
    $('#pages').DataTable({
        responsive: true,
        language: window.DataTableLanguage,
        columns: [
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