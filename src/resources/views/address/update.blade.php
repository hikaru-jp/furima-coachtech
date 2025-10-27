@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/address-edit.css') }}">
@endpush

@section('content')
    <div class="address-edit-wrapper">


        <div class="header-search">
            <input type="text" placeholder="なにをお探しですか？">
        </div>

        <nav class="header-menu">
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
            <a href="{{ route('mypage.index') }}">マイページ</a>
            <a href="{{ route('item.create') }}">出品</a>
        </nav>
        </header>

        <!-- タイトル -->
        <h1 class="address-edit-title">住所の変更</h1>

        <!-- 住所変更フォーム -->

        <form class="address-edit-form" action="{{ route('address.update', ['item_id' => $item->id ?? 0]) }}"
            method="POST">
            @csrf

            <!-- 郵便番号 -->
            <div>
                <label for="postal_code">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code"
                    value="{{ old('postal_code', Auth::user()->postal_code) }}" placeholder="例）123-4567">
            </div>

            <!-- 住所 -->
            <div>
                <label for="address">住所</label>
                <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->address) }}"
                    placeholder="例）東京都中央区築地１丁目２番３号">
            </div>

            <!-- 建物名 -->
            <div>
                <label for="building">建物名</label>
                <input type="text" id="building" name="building" value="{{ old('building', Auth::user()->building) }}"
                    placeholder="例）築地テラスビル１０１号室">
            </div>

            <!-- 更新ボタン -->
            <button type="submit" class="address-edit-submit">更新する</button>
        </form>

    </div>
@endsection
