@extends('layouts.backend')

@section('title', __('Add Single Product'))

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
            <form id="form" enctype="multipart/form-data" action="{{ route('backend.products.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Add Single Product') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">{{ __('Supplier') }}</label>
                            <select name="supplier_id" class="form-control">
                                <option value="">{{ __('Not set') }}</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">
                                    {{ $supplier->shop_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('Category') }}</label>
                            <select name="category_id" class="form-control">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
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
                            <label class="form-label">{{ __('Description') }}</label>
                            @foreach(config('app.locales') as $locale)
                            <div class="py-2">
                                <textarea name="description[{{ $locale }}]" rows="6"
                                    class="form-control">{{ __($locale) }}</textarea>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('Price') }}</label>
                            <input name="price" type="number" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('Stock') }}</label>
                            <input name="stock" type="number" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Photo') }}</label>
                            <div class="custom-file">
                                <input type="file" name="photo" class="custom-file" id="customFile">
                                <label class="custom-file-label" for="customFile">{{ __('Choose file') }}</label>
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="{{ __('Save') }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection