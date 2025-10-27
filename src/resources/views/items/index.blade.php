@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endpush

@section('content')
    <div class="item-list-wrapper">

        <div class="header-search">
            <input type="text" placeholder="なにをお探しですか？">
        </div>

        <nav class="header-menu">
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('mypage.index') }}">マイページ</a>
          <a href="{{ route('item.create') }}">出品</a>
        </nav>

        <!-- タブメニュー -->
        <div class="item-tab-menu">
            <span class="tab active">おすすめ</span>
            <span class="tab">マイリスト</span>
        </div>

        <!-- 商品一覧（仮） -->
        <div class="item-grid">
            <div class="item-card">
                <div class="item-image">商品画像</div>
                <p class="item-name">商品名</p>
            </div>

            <div class="item-card">
                <div class="item-image">商品画像</div>
                <p class="item-name">商品名</p>
            </div>

            <div class="item-card">
                <div class="item-image">商品画像</div>
                <p class="item-name">商品名</p>
            </div>

            <div class="item-card">
                <div class="item-image">商品画像</div>
                <p class="item-name">商品名</p>
            </div>

            <div class="item-card">
                <div class="item-image">商品画像</div>
                <p class="item-name">商品名</p>
            </div>

            <div class="item-card">
                <div class="item-image">商品画像</div>
                <p class="item-name">商品名</p>
            </div>
        </div>

    </div>
@endsection
