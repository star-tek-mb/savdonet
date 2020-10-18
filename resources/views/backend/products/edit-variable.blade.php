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
                        <div class="form-group">
                            <label class="form-label">{{ __('Options') }}</label>
                            <select class="form-control options" disabled multiple="multiple" style="width:100%">
                                @foreach($options as $option)
                                <option value="{{ $option->id }}" @if (in_array($option->id, $product->options))
                                    selected @endif>{{ $option->title }}</option>
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
                        <div class="form-group">
                            <label class="form-label">{{ __('Values') }}</label>
                            <div class="form-row">
                                <div class="col">
                                    <select class="form-control values" multiple="multiple" style="width: 100%;">
                                        @foreach($options as $option)
                                        <optgroup label="{{ $option->title }}" disabled>
                                            @foreach($option->values as $value)
                                            <option value="{{ $value->id }}">{{ $value->title }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="add-variation btn btn-primary"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($product->variations as $variation)
                <div class="card variation">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Variation') }}: {{ $variation->full_name }}</h3>
                        <div class="card-tools">
                            <button type="button" onclick="$(this).parent().parent().parent().remove();"
                                class="btn btn-tool bg-red"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 my-auto">
                                <img class="img-fluid" src="{{ Storage::url($variation->photo_url) }}"></img>
                            </div>
                            <div class="col-9">
                                <input type="hidden" name="variation[]" value="{{ $variation->id }}">
                                <input type="hidden" name="values[]" value="{{ implode(',', $variation->values) }}">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Price') }}</label>
                                    <input name="price[]" type="number" class="form-control"
                                        value="{{ $variation->price }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('Stock') }}</label>
                                    <input name="stock[]" type="number" class="form-control"
                                        value="{{ $variation->stock }}">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Photo') }}</label>
                                    <div class="custom-file">
                                        <input type="file" name="photo[]" class="custom-file"
                                            id="photo{{ $variation->id }}">
                                        <label class="custom-file-label"
                                            for="photo{{ $variation->id }}">{{ $variation->photo_url }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Sale') }}</label>
                                    <div class="row">
                                        <div class="col">
                                            <input name="sale_dates[]" type="text" class="sale-date form-control"
                                                value="@if ($variation->sale_start && $variation->sale_end) {{ $variation->sale_start->format('d.m.Y') }} - {{ $variation->sale_end->format('d.m.Y') }} @endif">
                                        </div>
                                        <div class="col">
                                            <input name="sale_price[]" type="number" class="form-control"
                                                placeholder="{{ __('Sale Price') }}"
                                                value="{{ $variation->sale_price }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div id="add-button" class="text-center pb-2">
                    <input type="submit" class="btn btn-primary" value="{{ __('Save') }}">
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
    $('.sale-date').daterangepicker({
        locale: window.DatePickerLocale
    });
});
</script>
@endpush

@push('js')
<script>
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
    $('.options').select2();
    $('.options').on('change', function() {
        console.log('changed');
        // get selected names
        var selected_names = [];
        var selected = $('option:selected', this).each(function(i, el) {
            selected_names.push(el.innerHTML);
        });
        // disable values, match options and values
        $('.values optgroup').each(function(i, el) {
            if (!selected_names.includes($(el).attr('label'))) {
                $(el).prop('disabled', true);
            } else {
                $(el).prop('disabled', false);
            }
        });
        // trigger changes
        $('.values').trigger('change.select2');
    });
    $('.values').select2();
    $('.values').on('change', function() {
        // do not select more than one option from optgroup
        $('.values optgroup').each(function(i, el) {
            var selected = $('option:selected', el);
            if (selected.length > 1) {
                $('option', el).prop('selected', false);
            }
        });
        $('.values').trigger('change.select2');
    });
    $('.add-variation').on('click', function(e) {
        // check if options and values count matched
        if ($('.options option:selected').length != $('.values option:selected').length) {
            Toastr.error("{{ __('Options count does not match values count') }}");
            return;
        }
        // check if exists
        var check = $('.variation input[type="hidden"][name="values[]"]');
        for (var i = 0; i < check.length; i++) {
            if ($(check[i]).val() != -1 && $(check[i]).val() == $('.values').val()) {
                console.log('check_val ' + $(check[i]).val());
                console.log('values_val ' + $('.values').val());
                Toastr.error("{{ __('Variation exists') }}");
                $('.values').val('').trigger('change');
                return;
            }
        }
        // get selected names
        var selected_names = '';
        var selected = $('.values option:selected');
        selected.each(function(i, el) {
            selected_names += $(el).text();
            if (i != selected.length - 1) {
                selected_names += ', ';
            }
        });
        // append variation (TODO: normalize code)
        $(`<div class="card variation">
            <div class="card-header">
                <h3 class="card-title">{{ __('Variation') }}: ` + selected_names + `</h3>
                <div class="card-tools">
                    <button type="button" onclick="$(this).parent().parent().parent().remove();" class="btn btn-tool bg-red"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" name="variation[]" value="-1">
                <input type="hidden" name="values[]" value="` +
            $('.values').val() + `">
                <div class="form-group">
                    <label class="form-label">{{ __('Price') }}</label>
                    <input name="price[]" type="number" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Stock') }}</label>
                    <input name="stock[]" type="number" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>{{ __('Photo') }}</label>
                    <div class="custom-file">
                        <input type="file" name="photo[]" class="custom-file" id="photovar` + $('.variation').length + `">
                        <label class="custom-file-label" for="photovar` + $('.variation').length + `">{{ __('Choose file') }}</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('Sale') }}</label>
                    <div class="row">
                        <div class="col">
                            <input name="sale_dates[]" type="text" class="sale-date form-control">
                        </div>
                        <div class="col">
                            <input name="sale_price[]" type="number" class="form-control"
                                placeholder="{{ __('Sale Price') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>`).insertBefore($('#add-button'));
        window.FileInput.init(); // refresh FileInput list
        $('.values').val('').trigger('change');
        $('.sale-date:last').daterangepicker({
            locale: window.DatePickerLocale
        });
    });
    $('.options').trigger('change');
});
</script>
@endpush