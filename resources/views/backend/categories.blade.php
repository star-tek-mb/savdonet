@extends('layouts.backend')

@section('title', __('Categories'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h3>{{ __('Correct following errors') }}:</h3>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Add Category') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">{{ __('Title') }}</label>
                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                <div class="col-12">
                                    <input name="title[{{ $locale }}]" type="text" class="form-control"
                                        placeholder="{{ __($locale) }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('Parent') }}</label>
                            <select name="parent_id" class="form-control">
                                <option value="">{{ __('Not set') }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    @php
                                    $par = $category->parent;
                                    $parents = array();
                                    while ($par) {
                                        array_push($parents, $par);
                                        $par = $par->parent;
                                    }
                                    $parents = array_reverse($parents);
                                    @endphp
                                    @foreach ($parents as $parent)
                                        {{ $parent->title }} - 
                                    @endforeach
                                    {{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Photo') }}</label>
                            <div class="custom-file">
                                <input type="file" name="photo" class="custom-file" id="customFile">
                                <label class="custom-file-label" for="customFile">{{ __('Choose file') }}</label>
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="{{ __('Add') }}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Categories') }}</h3>
                </div>
                <div class="card-body">
                    <table id="category" class="table table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ __('Photo') }}</th>
                                @foreach(config('app.locales') as $locale)
                                <th>{{ __($locale) }}</th>
                                @endforeach
                                <th>{{ __('Parent') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td><img class="img-fluid" src="{{ Storage::url($category->photo_url) }}"></img></td>
                                @foreach(config('app.locales') as $locale)
                                <td>{{ $category->getTranslation('title', $locale) }}</td>
                                @endforeach
                                <td>@if ($category->parent) {{ $category->parent->title }} @else {{ __('Not set') }}
                                    @endif</td>
                                <td>
                                    <form class="d-none"
                                        action="{{ route('backend.categories.destroy', $category->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a class="btn btn-tool bg-red"
                                        onclick="event.preventDefault(); $(this).prev().submit();"><i
                                            class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
        columns: [{
                width: '20%',
                orderable: false,
                searchable: false,
                responsivePriority: 1
            },
            {
                responsivePriority: 2
            },
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