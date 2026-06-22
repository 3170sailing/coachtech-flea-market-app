@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@section('content')
<div class="item-detail">
    <div class="item-detail__image">
        <div class="item-detail__image-box">
            @if ($item->image)
                <img
                    class="item-detail__img"
                    src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}"
                    alt="{{ $item->name }}">
            @else
                <span>商品画像</span>
            @endif
        </div>
    </div>

    <div class="item-detail__content">
        <h1 class="item-detail__name">
            {{ $item->name }}
        </h1>

        <p class="item-detail__brand">
            {{ $item->brand }}
        </p>

        <p class="item-detail__price">
            ¥{{ number_format($item->price) }} <span>税込</span>
        </p>

        <div class="item-action">

            <div class="item-action__like">
                <form action="/item/{{ $item->id }}/like" method="post">
                    @csrf

                    <button class="item-action__button" type="submit">
                        @if ($item->likes->where('user_id', Auth::id())->count())
                            <img
                                src="{{ asset('images/ハートロゴ_ピンク.png') }}"
                                alt="いいね済み"
                                class="item-action__icon">
                        @else
                            <img
                                src="{{ asset('images/ハートロゴ_デフォルト.png') }}"
                                alt="いいね"
                                class="item-action__icon">
                        @endif
                    </button>
                </form>

                <span class="item-action__count">
                    {{ $item->likes->count() }}
                </span>
            </div>

            <div class="item-action__comment">
                <img
                    src="{{ asset('images/ふきだしロゴ.png') }}"
                    alt="コメント"
                    class="item-action__icon">

                <span class="item-action__count">
                    {{ $item->comments->count() }}
                </span>
            </div>

        </div>

        <a class="item-detail__purchase" href="/purchase/{{ $item->id }}">
            購入手続きへ
        </a>

        <section class="item-detail__section">
            <h2 class="item-detail__heading">商品説明</h2>
            <p class="item-detail__description">
                {{ $item->description }}
            </p>
        </section>

        <section class="item-detail__section">
            <h2 class="item-detail__heading">商品の情報</h2>

            <div class="item-detail__info">
                <h3 class="item-detail__info-title">カテゴリー</h3>
                <div class="item-detail__categories">
                    @foreach ($item->categories as $category)
                        <span class="item-detail__category">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="item-detail__info">
                <h3 class="item-detail__info-title">商品の状態</h3>
                <p>{{ $item->condition->name }}</p>
            </div>
        </section>

        <section class="item-detail__comments">
            <h2 class="item-detail__comment-title">
                コメント({{ $item->comments->count() }})
            </h2>

            @foreach ($item->comments as $comment)
                <div class="comment">
                    <div class="comment__user">
                        <div class="comment__icon"></div>
                        <p class="comment__name">{{ $comment->user->name }}</p>
                    </div>
                    <p class="comment__text">{{ $comment->content }}</p>
                </div>
            @endforeach

            <form class="comment-form" action="/item/{{ $item->id }}/comment" method="post">
                @csrf

                <label class="comment-form__label" for="content">
                    商品へのコメント
                </label>

                <textarea
                    class="comment-form__textarea"
                    name="content"
                    id="content">{{ old('content') }}</textarea>

                @error('content')
                    <p class="comment-form__error">
                        {{ $message }}
                    </p>
                @enderror

                <button class="comment-form__button" type="submit">
                    コメントを送信する
                </button>
            </form>
        </section>
    </div>
</div>
@endsection