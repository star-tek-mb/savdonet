@extends('layouts.backend')

@section('title', __('Add Supplier'))

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
            <h3 class="card-title">{{ __('Add Supplier') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.suppliers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">{{ __('Full name') }}</label>
                    <input name="name" type="text" class="form-control" placeholder="{{ __('Full name') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Shop name') }}</label>
                    <input name="shop_name" type="text" class="form-control" placeholder="{{ __('Shop name') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Address') }}</label>
                    <input name="address" type="text" class="form-control" placeholder="{{ __('Address') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Phone') }}</label>
                    <input name="phone" type="text" class="form-control" placeholder="{{ __('Phone') }}">
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="{{ __('Add') }}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection