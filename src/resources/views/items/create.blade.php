@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/create.css') }}">
@endsection

@section('content')
<div class="sell">
    <h1 class="sell__title">商品の出品</h1>

    <form class="sell-form" action="/sell" method="post" enctype="multipart/form-data">
        @csrf

        <div class="sell-form__group">
            <label class="sell-form__label">商品画像</label>
            @error('image')
                <p class="sell-form__error">{{ $message }}</p>
            @enderror
            <div class="sell-form__image">
                <img
                    id="item-image-preview"
                    class="sell-form__image-preview"
                    src=""
                    alt="商品画像プレビュー"
                    style="display: none;">

                <label class="sell-form__image-button">
                    画像を選択する
                    <input
                        id="item-image"
                        class="sell-form__image-input"
                        type="file"
                        name="image">
                </label>
            </div>
        </div>

        <div class="sell-form__section">
            <h2 class="sell-form__section-title">商品の詳細</h2>

            <div class="sell-form__group">
                <label class="sell-form__label">カテゴリー</label>
                <div class="sell-form__categories">
                    @foreach ($categories as $category)
                        <label class="sell-form__category">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="sell-form__group">
                <label class="sell-form__label" for="condition_id">商品の状態</label>
                <select class="sell-form__select" name="condition_id" id="condition_id">
                    <option value="">選択してください</option>
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="sell-form__section">
            <h3 class="sell-form__section-title">商品名と説明</h3>

            <div class="sell-form__group">
                <label class="sell-form__label" for="name">商品名</label>
                <input class="sell-form__input" type="text" name="name" id="name">
            </div>

            <div class="sell-form__group">
                <label class="sell-form__label" for="brand">ブランド名</label>
                <input class="sell-form__input" type="text" name="brand" id="brand">
            </div>

            <div class="sell-form__group">
                <label class="sell-form__label" for="description">商品の説明</label>
                <textarea class="sell-form__textarea" name="description" id="description"></textarea>
            </div>

            <div class="sell-form__group">
                <label class="sell-form__label" for="price">販売価格</label>
                <div class="sell-form__price">
                    <span class="sell-form__price-mark">¥</span>
                    <input class="sell-form__input sell-form__input--price" type="number" name="price" id="price">
                </div>
            </div>
        </div>

        <button class="sell-form__button" type="submit">出品する</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('item-image');
    const preview = document.getElementById('item-image-preview');

    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (!file) {
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    });
});
</script>

@endsection