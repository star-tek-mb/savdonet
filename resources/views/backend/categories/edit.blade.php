@extends('layouts.backend')

@section('title', __('Edit Category'))

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
            <h3 class="card-title">{{ __('Edit Category') }}</h3>
            <div class="card-tools">
                <a href="{{ route('category.show', $category->id) }}" class="btn btn-tool bg-blue"><i class="fas fa-eye"></i></a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.categories.update', $category->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">#</label>
                    <input name="number" type="number" class="form-control" value="{{ old('number', $category->number) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Title') }}</label>
                    <div class="row">
                        @foreach(config('app.locales') as $locale)
                        <div class="col-12">
                            <input name="title[{{ $locale }}]" type="text" class="form-control"
                                value="{{ @old('title')[$locale] ?? $category->getTranslation('title', $locale) }}">
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Parent') }}</label>
                    <select name="parent_id" class="form-control">
                        <option value="">{{ __('Not set') }}</option>
                        @foreach($categories as $c)
                        <option value="{{ $c->id }}" @if ($category->parent_id == $c->id || old('parent_id') == $c->id) selected @endif>
                            {{ $c->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row mt-4">
                    <div class="col-3">
                        <img class="img-fluid" src="{{ Storage::url($category->photo_url) }}"></img>
                    </div>
                    <div class="col-9">
                        <div class="form-group">
                            <label>{{ __('Photo') }}</label>
                            <div class="custom-file">
                                <input type="file" name="photo" class="custom-file" id="customFile">
                                <label class="custom-file-label" for="customFile">{{ $category->photo_url }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="{{ __('Save') }}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection