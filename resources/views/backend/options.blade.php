@extends('layouts.backend')

@section('title', __('Options'))

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
                    <h3 class="card-title">{{ __('Add Option') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.options.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach(config('app.locales') as $locale)
                            <div class="col">
                                <input name="title[{{ $locale }}]" type="text" class="form-control"
                                    placeholder="{{ __($locale) }}">
                            </div>
                            @endforeach
                            <div class="col-auto">
                                <button type="submit" class="btn bg-blue"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @foreach ($options as $option)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $option->title }}</h3>
                    <div class="card-tools">
                        <form class="d-none" action="{{ route('backend.options.destroy', $option->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                        </form>
                        <a class="btn btn-tool bg-red" onclick="event.preventDefault(); $(this).prev().submit();"><i
                                class="fas fa-trash"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <h4>{{ __('Edit') }}</h4>
                    <form action="{{ route('backend.options.update', $option->id) }}" method="post">
                        <div class="row my-2">

                            @csrf
                            @method('PUT')

                            @foreach(config('app.locales') as $locale)
                            <div class="col">
                                <input class="form-control" name="title[{{ $locale }}]" type="text"
                                    value="{{ $option->getTranslation('title', $locale) }}">
                            </div>
                            @endforeach
                            <div class="col-auto">
                                <a class="btn bg-green"
                                    onclick="event.preventDefault(); $(this).parent().parent(). parent().submit();"><i
                                        class="fas fa-save"></i></a>
                            </div>
                        </div>
                    </form>
                    <h4>{{ __('Values') }}</h4>
                    @foreach ($option->values as $value)
                    <div class="row my-2">
                        <form class="row col" action="{{ route('backend.options.value.update', $value->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            @foreach(config('app.locales') as $locale)
                            <div class="col">
                                <input class="form-control" name="title[{{ $locale }}]" type="text"
                                    value="{{ $value->getTranslation('title', $locale) }}">
                            </div>
                            @endforeach
                        </form>
                        <div class="col-auto">
                            <form class="d-none" action="{{ route('backend.options.value.destroy', $value->id) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                            </form>
                            <a class="btn bg-green"
                                onclick="event.preventDefault(); $(this).parent().prev().submit();"><i
                                    class="fas fa-save"></i></a>
                            <a class="btn bg-red" onclick="event.preventDefault(); $(this).prev().submit();"><i
                                    class="fas fa-trash"></i></a>
                        </div>
                    </div>
                    @endforeach
                    <h4>{{ __('Add Value') }}</h4>
                    <form action="{{ route('backend.options.value.store', $option->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="row my-2">
                                @foreach(config('app.locales') as $locale)
                                <div class="col">
                                    <input name="title[{{ $locale }}]" type="text" class="form-control"
                                        placeholder="{{ __($locale) }}">
                                </div>
                                @endforeach
                                <div class="col-auto">
                                    <button type="submit" class="btn bg-blue"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    $('.data-tables').DataTable({
        responsive: true,
        paging: false,
        ordering: false,
        info: false,
        searching: false,
        language: window.DataTableLanguage,
        columns: [{
                "width": "30%"
            },
            {
                "width": "30%"
            },
            {
                "width": "30%"
            },
            {
                "width": "10%"
            },
        ]
    });
});
</script>
@endpush