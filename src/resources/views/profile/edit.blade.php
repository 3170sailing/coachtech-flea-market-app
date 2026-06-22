@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/edit.css') }}">
@endsection

@section('content')

<div class="profile">
    <h1 class="profile__title">プロフィール設定</h1>

    <form
        action="/mypage/profile"
        method="post"
        enctype="multipart/form-data"
        class="profile-form">

        @csrf
        @method('PATCH')

        <div class="profile-form__image-area">
            <div class="profile-form__image-preview">
                @if(optional(Auth::user()->profile)->image)
                    <img
                        id="preview"
                        src="{{ asset('storage/' . Auth::user()->profile->image) }}"
                        alt="プロフィール画像">
                @else
                    <img
                        id="preview"
                        src=""
                        alt="プロフィール画像"
                        style="display:none;">
                @endif
            </div>

            <label class="profile-form__image-button">
                画像を選択する
                <input
                    id="image"
                    class="profile-form__image-input"
                    type="file"
                    name="image">
            </label>
        </div>

        <div class="profile-form__group">
            <label class="profile-form__label" for="name">
                ユーザー名
            </label>

            <input
                class="profile-form__input"
                type="text"
                name="name"
                id="name"
                value="{{ old('name', Auth::user()->name) }}"
                placeholder="既存の値が入力されている">
        </div>

        <div class="profile-form__group">
            <label class="profile-form__label" for="postal_code">
                郵便番号
            </label>

            <input
                class="profile-form__input"
                type="text"
                name="postal_code"
                id="postal_code"
                value="{{ old('postal_code', optional(Auth::user()->profile)->postal_code) }}"
                placeholder="既存の値が入力されている">
        </div>

        <div class="profile-form__group">
            <label class="profile-form__label" for="address">
                住所
            </label>

            <input
                class="profile-form__input"
                type="text"
                name="address"
                id="address"
                value="{{ old('address', optional(Auth::user()->profile)->address) }}"
                placeholder="既存の値が入力されている">
        </div>

        <div class="profile-form__group">
            <label class="profile-form__label" for="building">
                建物名
            </label>

            <input
                class="profile-form__input"
                type="text"
                name="building"
                id="building"
                value="{{ old('building', optional(Auth::user()->profile)->building) }}"
                placeholder="既存の値が入力されている">
        </div>

        <button
            type="submit"
            class="profile-form__button">
            更新する
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');

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