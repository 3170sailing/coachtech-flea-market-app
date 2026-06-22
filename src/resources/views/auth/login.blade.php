@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login">
    <div class="login__inner">
        <h1 class="login__title">ログイン</h1>

        <form class="login-form" action="/login" method="post">
            @csrf

            <div class="login-form__group">
                <label class="login-form__label" for="email">メールアドレス</label>
                <input class="login-form__input" type="email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                    <p class="login-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="login-form__group">
                <label class="login-form__label" for="password">パスワード</label>
                <input class="login-form__input" type="password" name="password" id="password">
                @error('password')
                    <p class="login-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="login-form__button">
                <button class="login-form__button-submit" type="submit">ログインする</button>
            </div>
        </form>

        <div class="login__register">
            <a class="login__register-link" href="/register">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection