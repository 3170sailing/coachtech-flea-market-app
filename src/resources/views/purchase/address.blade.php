@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/address.css') }}">
@endsection

@section('content')
<div class="address">
    <h2 class="address__title">住所の変更</h2>

    <form class="address-form" action="/purchase/address/{{ $item->id }}" method="post">
        @csrf

        <div class="address-form__group">
            <label class="address-form__label" for="postal_code">郵便番号</label>
            <input class="address-form__input" type="text" name="postal_code" id="postal_code"
                value="{{ old('postal_code', optional(Auth::user()->profile)->postal_code) }}">
        </div>

        <div class="address-form__group">
            <label class="address-form__label" for="address">住所</label>
            <input class="address-form__input" type="text" name="address" id="address"
                value="{{ old('address', optional(Auth::user()->profile)->address) }}">
        </div>

        <div class="address-form__group">
            <label class="address-form__label" for="building">建物名</label>
            <input class="address-form__input" type="text" name="building" id="building"
                value="{{ old('building', optional(Auth::user()->profile)->building) }}">
        </div>

        <button class="address-form__button" type="submit">更新する</button>
    </form>
</div>
@endsection