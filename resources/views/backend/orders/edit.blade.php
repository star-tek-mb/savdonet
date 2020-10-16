@extends('layouts.backend')

@section('title', __('Edit Order') . ' №' . $order->id)

@section('content')

<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Edit Order') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <div class="form-group">
                        <label class="form-label">{{ __('Shipping Method') }}</label>
                        <select id="delivery_select" name="delivery" class="form-control">
                            @foreach($delivery as $method)
                            <option value="{{ $method }}" @if ($order->delivery == $method) selected @endif>{{ __($method) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('Full name') }}</label>
                        <input name="fullname" type="text" class="form-control" placeholder="{{ __('Full name') }}"
                            value="{{ $order->name }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('E-Mail Address') }}</label>
                        <input name="email" type="text" class="form-control" placeholder="mail@example.com"
                            value="{{ $order->email }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('Phone') }}</label>
                        <input name="phone" type="text" class="form-control" placeholder="+998XXXXXXXXX"
                            value="{{ $order->phone }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('Region') }}</label>
                        <select name="region" class="form-control">
                            @foreach($regions as $region)
                            <option value="{{ $region }}" @if ($order->region == $region) selected
                                @endif>{{ __($region) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('City') }}</label>
                        <input name="city" type="text" class="form-control" required placeholder="{{ __('City') }}"
                            value="{{ $order->city }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('Address') }}</label>
                        <input name="address" type="text" class="form-control" required
                            placeholder="{{ __('Street, Apartment') }}" value="{{ $order->address }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('Comment') }}</label>
                        <textarea name="comment" rows="6" class="form-control"
                            placeholder="{{ __('Location orient, your home time') }}">{{ $order->comment }}</textarea>
                    </div>
                    <label class="form-label">{{ __('Status') }}</label>
                    <div class="form-row">
                        <select name="status" class="form-control" style="width: 100%;">
                            @foreach($statuses as $status)
                            <option value="{{ $status }}" @if ($order->status == $status) selected
                                @endif>{{ __($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection