@extends('layouts.backend')

@section('title', __('Edit Supplier'))

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
            <h3 class="card-title">{{ __('Edit Supplier') }}</h3>
            <div class="card-tools">
                <a href="{{ route('backend.suppliers.show', $supplier->id) }}" class="btn btn-tool bg-blue"><i
                        class="fas fa-eye"></i></a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.suppliers.update', $supplier->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">{{ __('Full name') }}</label>
                    <input name="name" type="text" class="form-control" placeholder="{{ __('Full name') }}"
                        value="{{ old('name', $supplier->name) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Shop name') }}</label>
                    <input name="shop_name" type="text" class="form-control" placeholder="{{ __('Shop name') }}"
                        value="{{ old('shop_name', $supplier->shop_name) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Address') }}</label>
                    <input name="address" type="text" class="form-control" placeholder="{{ __('Address') }}"
                        value="{{ old('address', $supplier->address) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Phone') }}</label>
                    <input name="phone" type="text" class="form-control" placeholder="{{ __('Phone') }}"
                        value="{{ old('phone', $supplier->phone) }}">
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="{{ __('Save') }}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection