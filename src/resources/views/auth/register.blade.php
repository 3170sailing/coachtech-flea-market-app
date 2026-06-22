@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="register">
    <div class="register__inner">
        <h1 class="register__title">会員登録</h1>

        <form class="register-form" action="/register" method="post">
            @csrf

            {{-- ユーザー名 --}}
            <div class="register-form__group">
                <label class="register-form__label" for="name">ユーザー名</label>
                <input class="register-form__input" type="text" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <p class="register-form__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="register-form__group">
                <label class="register-form__label" for="email">メールアドレス</label>
                <input class="register-form__input" type="email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                    <p class="register-form__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- パスワード --}}
            <div class="register-form__group">
                <label class="register-form__label" for="password">パスワード</label>
                <input class="register-form__input" type="password" name="password" id="password">
                @error('password')
                    <p class="register-form__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 確認用パスワード --}}
            <div class="register-form__group">
                <label class="register-form__label" for="password_confirmation">確認用パスワード</label>
                <input class="register-form__input" type="password" name="password_confirmation" id="password_confirmation">
            </div>

            <div class="register-form__button">
                <button class="register-form__button-submit" type="submit">登録する</button>
            </div>
        </form>

        <div class="register__login">
            <a class="register__login-link" href="/login">ログインはこちら</a>
        </div>
    </div>
</div>
@endsection