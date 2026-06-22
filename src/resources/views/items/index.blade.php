@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('content')
<div class="item-list">
    <div class="item-list__tabs">
        <a
            href="/?page=recommend"
            class="item-list__tab {{ request('page') != 'mylist' ? 'item-list__tab--active' : '' }}">
            おすすめ
        </a>

        <a
            href="/?page=mylist"
            class="item-list__tab {{ request('page') == 'mylist' ? 'item-list__tab--active' : '' }}">
            マイリスト
        </a>
    </div>

    <div class="item-list__content">
        @foreach ($items as $item)
            <a class="item-card" href="/item/{{ $item->id }}">
                <div class="item-card__image">
                    @if ($item->order)
                        <span class="item-card__sold">sold</span>
                    @endif

                    @if ($item->image)
                        <img
                            class="item-card__img"
                            src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}"
                            alt="{{ $item->name }}">
                    @else
                        <span class="item-card__placeholder">商品画像</span>
                    @endif
                </div>

                <p class="item-card__name">{{ $item->name }}</p>
            </a>
        @endforeach
    </div>

</div>
@endsection