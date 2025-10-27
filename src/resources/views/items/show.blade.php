@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item-show.css') }}">
@endpush

@section('content')
    <div class="item-show-wrapper">


        <div class="header-search">
            <input type="text" placeholder="なにをお探しですか？">
        </div>

        <nav class="header-menu">
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('mypage.index') }}">マイページ</a>
            <a href="{{ route('item.create') }}">出品</a>
        </nav>
        </header>

        <!-- 商品詳細 -->
        <div class="item-detail">

            <!-- 左：商品画像 -->
            <div class="item-image-box">
                <div class="item-image">商品画像</div>
            </div>

            <!-- 右：商品情報 -->
            <div class="item-info">
                <h2 class="item-name">商品名がここに入る</h2>
                <p class="item-brand">ブランド名</p>
                <p class="item-price">¥47,000 <span class="tax">(税込)</span></p>

                <form method="GET" action="{{ route('purchase.confirm', 1) }}"> {{-- 仮：商品IDに置換 --}}
                    <button type="submit" class="buy-btn">購入手続きへ</button>
                </form>
                <div class="item-description">
                    <h3>商品説明</h3>
                    <p>
                        カラー：グレー<br>
                        新品。商品の状態は良好です。傷もありません。<br>
                        購入後、即発送いたします。
                    </p>
                </div>

                <div class="item-info-section">
                    <h3>商品の情報</h3>
                    <p><strong>カテゴリー：</strong> 洋服, メンズ</p>
                    <p><strong>商品の状態：</strong> 良好</p>
                </div>

                <div class="item-comment-section">
                    <h3>コメント (1)</h3>

                    <div class="comment">
                        <div class="comment-user">admin</div>
                        <p class="comment-text">こちらにコメントが入ります。</p>
                    </div>
                    
                    <form class="comment-form" action="{{ route('items.comment', 1) }}" method="POST"> {{-- 仮ID: 1 --}}
                        @csrf
                        <label for="comment">商品のコメント</label>
                        <textarea id="comment" name="comment" placeholder="コメントを入力"></textarea>
                        <button type="submit" class="comment-submit">コメントを送信する</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
