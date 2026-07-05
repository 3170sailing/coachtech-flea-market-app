@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-email">
    <p class="verify-email__message">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

    <a
        href="http://localhost:8025"
        target="_blank"
        class="verify-email__button">
        認証はこちらから
    </a>

    <form
        action="{{ route('verification.send') }}"
        method="post"
        class="verify-email__form">
        @csrf

        <button type="submit" class="verify-email__resend">
            認証メールを再送する
        </button>
    </form>
</div>
@endsection