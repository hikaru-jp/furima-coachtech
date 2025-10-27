@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
@endpush

@section('content')
    <header class="header">
        <!-- 検索フォーム -->
        <div class="search-box">
            <input type="text" placeholder="なにをお探しですか？" class="search-input">
        </div>
        <!-- 右メニュー -->
        <nav class="header-menu">
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">ログアウト</button>
            </form> <a href="{{ route('mypage.index') }}" class="menu-link">マイページ</a>
            {{-- <a href="{{ route('item.create') }}" class="sell-btn">出品</a> --}}
        </nav>
    </header>

    <!-- タイトル -->
    <div class="profile-edit-wrapper">
        <h1 class="profile-edit-title">プロフィール設定</h1>

        <!-- アイコンと画像選択 -->
        <div class="profile-edit-icon">
            <div class="icon-circle">
                @if ($user->image_path)
                    <img src="{{ asset('storage/' . $user->image_path) }}" alt="プロフィール画像"
                        style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 150 150"
                        fill="none">
                        <circle cx="75" cy="75" r="75" fill="#D9D9D9" />
                    </svg>
                @endif
            </div>
            <label for="image">画像を選択する</label>
        </div>

        <!-- プロフィール編集フォーム -->
        <form class="profile-edit-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">


            @csrf

            <!-- 画像 -->
            <input type="file" id="image" name="image" style="display:none;">

            <!-- ユーザー名 -->
            <div>
                <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>

            <!-- 郵便番号 -->
            <div>
                <label for="postal_code">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code"
                    value="{{ old('postal_code', $user->postal_code) }}">
            </div>

            <!-- 住所 -->
            <div>
                <label for="address">住所</label>
                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">

            </div>

            <!-- 建物名 -->
            <div>
                <label for="building">建物名</label>
                <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
            </div>

            <!-- 更新ボタン -->
            <button type="submit" class="profile-edit-submit">更新する</button>
        </form>

    </div>
@endsection
