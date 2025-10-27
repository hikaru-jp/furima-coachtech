@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item-create.css') }}">
@endpush

@section('content')
    <div class="item-create-wrapper">



        <div class="header-search">
            <input type="text" placeholder="なにをお探しですか？">
        </div>

        <nav class="header-menu">
             <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                 @csrf
        <button type="submit" class="logout-btn" style="background:none; border:none; color:#333; cursor:pointer;">
            ログアウト
        </button>
    </form>
            <a href="{{ route('mypage.index') }}">マイページ</a>
            <a href="{{ route('item.create') }}" class="active">出品</a>
        </nav>
        </header>

        <h1 class="item-create-title">商品の出品</h1>

        <!-- 出品 -->
       <form class="item-create-form" method="POST" action="{{ route('items.store') }}">
            @csrf

            <!-- 商品画像 -->
            <div class="image-upload">
                <label for="item_image">画像を選択する</label>
                <input type="file" id="item_image" name="item_image">
            </div>

            <!-- カテゴリー -->
            <div>
                <label>商品の詳細</label>
                <div class="category-section">
                    <span class="category-tag">ファッション</span>
                    <span class="category-tag">家電</span>
                    <span class="category-tag">インテリア</span>
                    <span class="category-tag">レディース</span>
                    <span class="category-tag">メンズ</span>
                    <span class="category-tag">コスメ</span>
                    <span class="category-tag">本</span>
                    <span class="category-tag">ゲーム</span>
                    <span class="category-tag">スポーツ</span>
                    <span class="category-tag">ハンドメイド</span>
                    <span class="category-tag">アクセサリー</span>
                    <span class="category-tag">おもちゃ</span>
                    <span class="category-tag">ベビー・キッズ</span>
                </div>
            </div>

            <!-- 商品状態 -->
            <div class="select-section">
                <label for="condition">商品の状態</label>
                <select id="condition" name="condition">
                    <option value="">選択してください</option>
                    <option value="new">良好</option>
                    <option value="like-new">目立った傷や汚れなし</option>
                    <option value="used">やや傷や汚れあり</option>
                    <option value="bad">状態が悪い</option>
                </select>
            </div>

            <!-- 商品名と説明 -->
            <div>
                <label for="name">商品名</label>
                <input type="text" id="name" name="name" placeholder="商品名を入力してください">
            </div>

            <div>
                <label for="brand">ブランド名</label>
                <input type="text" id="brand" name="brand" placeholder="ブランド名を入力してください">
            </div>

            <div>
                <label for="description">商品の説明</label>
                <textarea id="description" name="description" placeholder="商品の特徴や状態を入力してください"></textarea>
            </div>

            <!-- 販売価格 -->
            <div>
                <label for="price">販売価格</label>
                <input type="number" id="price" name="price" placeholder="¥">
            </div>

            <!-- 出品ボタン -->
            <button type="submit" class="item-create-submit">出品する</button>
        </form>

    </div>
@endsection
