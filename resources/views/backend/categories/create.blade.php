@extends('layouts.backend')

@section('title', __('Add Category'))

@section('content')
<div class="container-fluid">
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
                    <label class="form-label">#</label>
                    <input name="number" type="number" class="form-control" value="{{ old('number') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Title') }}</label>
                    <div class="row">
                        @foreach(config('app.locales') as $locale)
                        <div class="col-12">
                            <input name="title[{{ $locale }}]" type="text" class="form-control"
                                placeholder="{{ __($locale) }}" value="{{ @old('title')[$locale] }}">
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Parent') }}</label>
                    <select name="parent_id" class="form-control">
                        <option value="">{{ __('Not set') }}</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if (old('parent_id') == $category->id) selected @endif>
                            {{ $category->full_name }}</option>
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
</div>
@endsection