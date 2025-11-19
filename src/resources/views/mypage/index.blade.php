@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/unit-item.css') }}">
@endpush

@section('content')
    <div class="profile-wrapper">

        <!-- プロフィール表示 -->
        <div class="profile-user">
            <div class="icon-circle">
                @if ($user->img_url)
                    <img src="{{ asset('storage/' . $user->img_url) }}" alt="" class="profile-icon">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 150 150"
                        fill="none">
                        <circle cx="75" cy="75" r="75" fill="#D9D9D9" />
                    </svg>
                @endif
            </div>
            <div class="profile-info">
                <h2>{{ $user->name }}</h2>
                <a href="{{ route('mypage.profile') }}" class="profile-edit-btn">
                    プロフィールを設定する
                </a>
            </div>
        </div>
        <!-- タブ -->
        <div class="profile-tabs">
            <a href="{{ route('mypage.index', ['page' => 'sell']) }}"
                class="tab {{ request('page', 'sell') === 'sell' ? 'active' : '' }}">
                出品した商品
            </a>
            <a href="{{ route('mypage.index', ['page' => 'buy']) }}"
                class="tab {{ request('page') === 'buy' ? 'active' : '' }}">
                購入した商品
            </a>
        </div>
        @php
            use Illuminate\Support\Str;
            $page = request('page', 'sell');
        @endphp
        {{-- 出品した商品 --}}
        @if ($page === 'sell')
            <div class="item-grid">
                @foreach ($items as $item)
                    <div class="item-card">
                        {{-- 画像表示 --}}
                        @if ($item->img_url)
                            <img src="{{ asset('storage/' . $item->img_url) }}" class="item-image">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" class="item-image">
                        @endif
                        <p class="item-name">{{ $item->name }}</p>
                    </div>
                @endforeach
            </div>
        @endif
        {{-- 購入した商品 --}}
        @if ($page === 'buy')
            <div class="item-grid">
                @foreach ($items as $purchase)
                    @php $item = $purchase->item; @endphp
                    <div class="item-card">
                        <x-unit-item :item="$item" />
                        @if ($item->is_sold)
                            <span class="sold-label">Sold</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
