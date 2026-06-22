@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/index.css') }}">
@endsection

@section('content')

@php
    $postalCode = $purchaseAddress['postal_code']
        ?? optional($profile)->postal_code;

    $address = $purchaseAddress['address']
        ?? optional($profile)->address;

    $building = $purchaseAddress['building']
        ?? optional($profile)->building;
@endphp

<div class="purchase">

    <form action="/purchase/{{ $item->id }}" method="post">
        @csrf

        <input type="hidden" name="payment_method_text" id="payment_method_text">

        <div class="purchase__content">

            <div class="purchase__left">

                <div class="purchase-item">
                    <div class="purchase-item__image">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}">
                    </div>

                    <div class="purchase-item__detail">
                        <h2 class="purchase-item__name">
                            {{ $item->name }}
                        </h2>

                        <p class="purchase-item__price">
                            ¥ {{ number_format($item->price) }}
                        </p>
                    </div>
                </div>

                <div class="purchase-section">
                    <h3 class="purchase-section__title">
                        支払い方法
                    </h3>

                    <div class="purchase-section__select-wrapper">
                        <select
                            name="payment_method"
                            class="purchase-section__select"
                            id="payment_method">

                            <option value="">
                                選択してください
                            </option>

                            <option value="konbini">
                                コンビニ支払い
                            </option>

                            <option value="card">
                                カード支払い
                            </option>
                        </select>
                    </div>
                </div>

                <div class="purchase-section">

                    <div class="purchase-section__header">
                        <h3 class="purchase-section__title">
                            配送先
                        </h3>

                        <a
                            href="/purchase/address/{{ $item->id }}"
                            class="purchase-section__link">
                            変更する
                        </a>
                    </div>

                    <div class="purchase-address">
                        <p class="purchase-address__postal">
                            〒 {{ $postalCode }}
                        </p>

                        <p class="purchase-address__address">
                            {{ $address }}
                        </p>

                        @if($building)
                            <p class="purchase-address__building">
                                {{ $building }}
                            </p>
                        @endif
                    </div>

                </div>

            </div>

            <div class="purchase__right">

                <div class="purchase-summary">

                    <div class="purchase-summary__row">
                        <span>商品代金</span>

                        <span>
                            ¥ {{ number_format($item->price) }}
                        </span>
                    </div>

                    <div class="purchase-summary__row">
                        <span>支払い方法</span>

                        <span id="payment-method-display">
                            選択してください
                        </span>
                    </div>

                </div>

                <button
                    type="submit"
                    class="purchase-summary__button">
                    購入する
                </button>

            </div>

        </div>

    </form>

</div>

<script>
    const paymentSelect = document.getElementById('payment_method');
    const paymentDisplay = document.getElementById('payment-method-display');
    const paymentText = document.getElementById('payment_method_text');

    paymentSelect.addEventListener('change', function () {
        const selectedText = this.options[this.selectedIndex].text;

        paymentDisplay.textContent = selectedText;
        paymentText.value = selectedText;
    });
</script>

@endsection