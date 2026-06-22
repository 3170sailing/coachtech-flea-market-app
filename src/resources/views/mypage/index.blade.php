@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection

@section('content')
<div class="mypage">
    <div class="mypage__profile">
        <div class="mypage__profile-image">
            @if(optional($user->profile)->image)
                <img
                    src="{{ asset('storage/' . $user->profile->image) }}"
                    alt="プロフィール画像">
            @endif
        </div>

        <h2 class="mypage__name">{{ $user->name }}</h2>

        <a class="mypage__edit" href="/mypage/profile">プロフィールを編集</a>
    </div>

    <div class="mypage__tabs">
        <a class="mypage__tab" href="/mypage?page=sell">出品した商品</a>
        <a class="mypage__tab" href="/mypage?page=buy">購入した商品</a>
    </div>

    <div class="mypage__items">
        @foreach ($items as $item)
            <a class="mypage-card" href="/item/{{ $item->id }}">
                <div class="mypage-card__image">
                    @if ($item->order)
                        <span class="mypage-card__sold">sold</span>
                    @endif

                    @if($item->image)
                        <img
                            class="mypage-card__img"
                            src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}"
                            alt="{{ $item->name }}">
                    @else
                        <span class="mypage-card__placeholder">商品画像</span>
                    @endif
                </div>

                <p class="mypage-card__name">{{ $item->name }}</p>
            </a>
        @endforeach
    </div>
</div>
@endsection