@extends('layouts.backend')

@section('title', __('Settings'))

@section('content')

<div class="container-fluid">
    <form action="{{ route('backend.settings') }}" method="POST">
        @foreach ($settings as $key => $value)
        <div class="form-group">
            <label class="form-label">{{ __($key) }}</label>
            <input name="key[]" type="hidden" value="{{ $key }}">
            <input name="value[]" type="text" class="form-control" value="{{ $value }}">
        </div>
        @endforeach
        <div class="text-center py-2">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </form>
</div>

@endsection