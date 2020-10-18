@extends('layouts.backend')

@section('title', __('Edit Product'))

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
            <form id="form" enctype="multipart/form-data" action="{{ route('backend.products.update', $product->id) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Edit Product') }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-tool bg-blue"><i
                                    class="fas fa-eye"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">{{ __('Supplier') }}</label>
                            <select name="supplier_id" class="form-control">
                                <option value="">{{ __('Not set') }}</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @if ($product->supplier_id == $supplier->id)
                                    selected @endif>
                                    {{ $supplier->shop_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('Category') }}</label>
                            <select name="category_id" class="form-control">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if ($product->category_id == $category->id)
                                    selected @endif>
                                    {{ $category->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <ul class="nav nav-pills nav-fill my-4" id="language_tabs" role="tablist">
                            @foreach(config('app.locales') as $locale)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if ($loop->first) active @endif" id="{{ $locale }}-tab"
                                    data-toggle="tab" href="#{{ $locale }}" role="tab" aria-controls="{{ $locale }}"
                                    aria-selected="true">{{ __($locale) }}</a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach(config('app.locales') as $locale)
                            <div class="tab-pane @if ($loop->first) active @endif" id="{{ $locale }}" role="tabpanel"
                                aria-labelledby="{{ $locale }}-tab">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Title') }}</label>
                                    <div class="row">
                                        <div class="col-12">
                                            <input name="title[{{ $locale }}]" type="text" class="form-control"
                                                placeholder="{{ __($locale) }}"
                                                value="{{ $product->getTranslation('title', $locale) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('Description') }}</label>
                                    <div class="py-2">
                                        <textarea name="description[{{ $locale }}]" rows="6"
                                            class="form-control">{{ $product->getTranslation('description', $locale) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label">{{ __('Media') }}</label>
                            <div id="media-dropzone" class="dropzone">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 my-auto">
                                <img class="img-fluid"
                                    src="{{ Storage::url($product->variations[0]->photo_url) }}"></img>
                            </div>
                            <div class="col-9">
                                <input type="hidden" name="variation[]" value="{{ $product->variations[0]->id }}">
                                <input type="hidden" name="values[]"
                                    value="{{ implode(',', $product->variations[0]->values) }}">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Price') }}</label>
                                    <input name="price[]" type="number" class="form-control"
                                        value="{{ $product->variations[0]->price }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('Stock') }}</label>
                                    <input name="stock[]" type="number" class="form-control"
                                        value="{{ $product->variations[0]->stock }}">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Photo') }}</label>
                                    <div class="custom-file">
                                        <input type="file" name="photo[]" class="custom-file" id="customFile">
                                        <label class="custom-file-label"
                                            for="customFile">{{ $product->variations[0]->photo_url }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Sale') }}</label>
                                    <div class="row">
                                        <div class="col">
                                            <input name="sale_dates[]" type="text" class="sale-date form-control"
                                                value="@if ($product->variations[0]->sale_start && $product->variations[0]->sale_end) {{ $product->variations[0]->sale_start->format('d.m.Y') }} - {{ $product->variations[0]->sale_end->format('d.m.Y') }} @endif">
                                        </div>
                                        <div class="col">
                                            <input name="sale_price[]" type="number" class="form-control"
                                                placeholder="{{ __('Sale Price') }}"
                                                value="{{ $product->variations[0]->sale_price }}">
                                        </div>
                                    </div>
                                </div>
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

@push('js')
<script>
Dropzone.options.mediaDropzone = {
    url: "{{ route('backend.products.dropzone.upload', $product->id) }}",
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    addRemoveLinks: true,
    init: function() {
        myDropzone = this;
        $.get("{{ route('backend.products.dropzone.init', $product->id) }}",
            function(data) {
                $.each(data.files, function(key, value) {
                    var file = {
                        name: value.file,
                        size: value.size
                    };
                    myDropzone.displayExistingFile(file, "/storage/" + value.file);
                });
            });
        myDropzone.on('removedfile', function(file) {
            $.ajax({
                url: "{{ route('backend.products.dropzone.delete', $product->id) }}",
                type: 'DELETE',
                data: {
                    file: file.name,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
        });
    },
};
$(document).ready(function() {
    $('textarea').summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
    });
    $('.sale-date').daterangepicker({
        locale: window.DatePickerLocale
    });
});
</script>
@endpush