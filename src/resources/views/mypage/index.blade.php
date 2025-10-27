@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
    <div class="profile-wrapper">

        <!-- ユーザー情報 -->
        <div class="profile-user">
            @if ($user->image_path)
                <img src="{{ asset('storage/' . $user->image_path) }}" alt="プロフィール画像" class="profile-icon">
            @else
                <img src="{{ asset('images/default-user.png') }}" alt="プロフィール画像" class="profile-icon">
            @endif

            <div class="profile-info">
                <h2>{{ $user->name }}</h2>
                <a href="{{ route('profile.setup') }}" class="profile-edit-btn">プロフィールを編集</a>
            </div>
        </div>


        <!-- タブ -->
        <div class="profile-tabs">
            <a href="{{ route('mypage.sold') }}" class="tab {{ request()->is('mypage/sold') ? 'active' : '' }}">出品した商品</a>
            <a href="{{ route('mypage.purchased') }}"
                class="tab {{ request()->is('mypage/purchased') ? 'active' : '' }}">購入した商品</a>
        </div>

    </div>
@endsection
