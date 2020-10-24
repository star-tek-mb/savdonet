@extends('layouts.backend')

@section('title', __('Add Page'))

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
            <h3 class="card-title">{{ __('Add Page') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.pages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">#</label>
                    <input name="number" type="number" class="form-control" value="{{ old('number', 1) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Slug') }}</label>
                    <input name="slug" type="text" class="form-control" value="{{ old('slug') }}">
                </div>
                <ul class="nav nav-pills nav-fill my-4" id="language_tabs" role="tablist">
                    @foreach(config('app.locales') as $locale)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link @if ($loop->first) active @endif" id="{{ $locale }}-tab" data-toggle="tab"
                            href="#{{ $locale }}" role="tab" aria-controls="{{ $locale }}"
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
                                        placeholder="{{ __($locale) }}" value="{{ @old('title')[$locale] }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('Description') }}</label>
                            <div class="py-2">
                                <textarea name="description[{{ $locale }}]" rows="6"
                                    class="form-control">{!! @old('description')[$locale] ?? __($locale) !!}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="callout callout-info" role="alert">
                    <p>{{ __('You can add photos to page only after saving') }}</p>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="{{ __('Add') }}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

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
});
</script>
@endpush