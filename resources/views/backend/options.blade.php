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
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="{{ __('Add') }}">
                        </div>
                    </form>
                </div>
            </div>
            @foreach ($options as $option)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Option') }}:
                        @foreach (config('app.locales') as $locale)
                        {{ $option->getTranslation('title', $locale) }}
                        @if (!$loop->last) , @endif
                        @endforeach
                    </h3>
                    <div class="card-tools">
                        <form class="d-none" action="{{ route('backend.options.destroy', $option->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                        </form>
                        <a class="btn btn-tool bg-red" onclick="event.preventDefault(); $(this).prev().submit();"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <h4>{{ __('Values') }}</h4>
                    <table class="data-tables text-center table-borderless table-sm dt-responsive nowrap"
                        style="width:100%">
                        <thead>
                            <tr>
                                @foreach(config('app.locales') as $locale)
                                <th>{{ __($locale) }}</th>
                                @endforeach
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($option->values as $value)
                            <tr>
                                @foreach(config('app.locales') as $locale)
                                <td>
                                    {{ $value->getTranslation('title', $locale) }}
                                </td>
                                @endforeach
                                <td>
                                    <form class="d-none" action="{{ route('backend.options.destroyValue', $value->id) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a class="btn btn-tool bg-red" onclick="event.preventDefault(); $(this).prev().submit();"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h4 class="pt-4">{{ __('Add Value') }}</h4>
                    <form action="{{ route('backend.options.storeValue', $option->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                <div class="col-12">
                                    <input name="title[{{ $locale }}]" type="text" class="form-control"
                                        placeholder="{{ __($locale) }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="{{ __('Add') }}">
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
        columns: [
            {
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