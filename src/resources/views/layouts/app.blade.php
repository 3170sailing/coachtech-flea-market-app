<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    @yield('css')

    <title>Flea Market</title>
</head>

<body>

<header class="header">
    <div class="header__inner">
        <div class="header__logo">
            <a href="/">
                <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
            </a>
        </div>

        <form class="header__search-form" action="/" method="get">
            @if(request('page'))
                <input type="hidden" name="page" value="{{ request('page') }}">
            @endif

            <input
                class="header__search-input"
                type="text"
                name="keyword"
                placeholder="なにをお探しですか？"
                value="{{ request('keyword') }}">
        </form>

        <nav class="header__nav">
            @auth
                <form action="/logout" method="post">
                    @csrf
                    <button class="header__nav-button" type="submit">ログアウト</button>
                </form>
            @else
                <a class="header__nav-link" href="/login">ログイン</a>
            @endauth

            <a class="header__nav-link" href="/mypage">マイページ</a>
            <a class="header__nav-sell" href="/sell">出品</a>
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>

</body>
</html>