@extends('layouts.backend')

@section('title', __('Categories'))

@section('content')
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Categories') }}</h3>
            <div class="card-tools">
                <a class="btn btn-tool bg-green" href="{{ route('backend.categories.create') }}"><i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="card-body">
            <table id="category" class="table table-bordered dt-responsive" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Photo') }}</th>
                        <th>{{ __('Full name') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->number }}</td>
                        <td><img class="img-fluid" src="{{ Storage::url($category->photo_url) }}"></img></td>
                        <td>{{ $category->full_name }}</td>
                        <td>
                            <a href="{{ route('category.show', $category->id) }}" class="btn btn-tool bg-blue"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('backend.categories.edit', $category->id) }}" class="btn btn-tool text-white bg-green"><i class="fas fa-edit"></i></a>
                            <form class="d-none" action="{{ route('backend.categories.destroy', $category->id) }}"
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
    $('#category').DataTable({
        responsive: true,
        language: window.DataTableLanguage,
        columns: [
            null,
            {
                width: '20%',
                orderable: false,
                searchable: false
            },
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