@extends('layouts.backend')

@section('title', __('Add Variable Product'))

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
                        <h3 class="card-title">{{ __('Add Variable Product') }}</h3>
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
                            <label class="form-label">{{ __('Options') }}</label>
                            <select name="options[]" class="form-control options" multiple="multiple"
                                style="width:100%">
                                @foreach($options as $option)
                                <option value="{{ $option->id }}">{{ $option->title }}</option>
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
                <div id="add-button" class="text-center pb-2">
                    <input type="submit" class="btn btn-primary" value="{{ __('Save') }}">
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    $('.options').select2();
    $('.options').on('change', function() {
        // clear variations, we are making option changes
        $('.variation').remove();
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
        var check = $('.variation input[type="hidden"]');
        for (var i = 0; i < check.length; i++) {
            if ($(check[i]).val() == $('.values').val()) {
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
                        <input type="file" name="photo[]" class="custom-file" id="photo` + $('.variation').length + `">
                        <label class="custom-file-label" for="photo` + $('.variation').length + `">{{ __('Choose file') }}</label>
                    </div>
                </div>
            </div>
        </div>`).insertBefore($('#add-button'));
        window.FileInput.init(); // refresh FileInput list
        $('.values').val('').trigger('change');
    });
});
</script>
@endpush