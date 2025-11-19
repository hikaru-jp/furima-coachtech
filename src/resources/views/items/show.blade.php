@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/item-show.css') }}">
@endpush

@section('content')
    <div class="item-show-wrapper">

        <div class="item-detail">
            @php
                use Illuminate\Support\Str;
            @endphp

            @if ($item->img_url)
                @if (Str::startsWith($item->img_url, 'http'))
                    <img src="{{ $item->img_url }}" alt="商品画像" class="item-image">
                @else
                    <img src="{{ asset('storage/' . $item->img_url) }}" alt="商品画像" class="item-image">
                @endif
            @else
                <img src="{{ asset('images/no-image.png') }}" alt="画像なし" class="item-image">
            @endif

            <div class="item-info">
                <h2 class="item-name">{{ $item->name }}</h2>
                <p class="item-brand">{{ $item->brand ?? 'ブランド未設定' }}</p>
                <p class="item-price">¥{{ number_format($item->price) }} <span class="tax">(税込)</span></p>
                <div class="favorite-section">
                    <form action="{{ route('favorites.toggle', $item->id) }}" method="POST" class="favorite-form">
                        @csrf
                        <button type="submit" class="icon-btn" style="background:none; border:none; cursor:pointer;">
                            @if (Auth::check() && $item->isLikedBy(Auth::user()))
                                <i class="fa-solid fa-star" style="color:#FFD700; font-size:22px;"></i>
                            @else
                                <i class="fa-regular fa-star" style="color:#999; font-size:22px;"></i>
                            @endif
                        </button>
                        <span>{{ $item->favorites->count() }}</span>
                    </form>
                    <div class="comment-icon" style="display:flex; align-items:center; gap:6px;">
                        <i class="fa-regular fa-comment" style="font-size:22px; color:#999;"></i>
                        <span>{{ $item->comments->count() }}</span>
                    </div>
                </div>

                <a href="{{ route('purchase.create', ['item_id' => $item->id]) }}" class="buy-btn">
                    購入手続きへ
                </a>
                <div class="item-description">
                    <h3>商品説明</h3>
                    <p>{{ $item->description ?? '説明はありません。' }}</p>
                </div>
                <div class="item-info-section">
                    <h3>商品の情報</h3>
                    <p><strong>カテゴリー：</strong>
                        @forelse ($item->categories as $category)
                            <span class="category-tag">{{ $category->name }}</span>
                        @empty
                            <span class="category-tag empty">未設定</span>
                        @endforelse
                    </p>
                    <p><strong>商品の状態：</strong> {{ $item->condition ?? '未設定' }}</p>
                </div>

                <div class="item-comment-section">
                    <h3>コメント ({{ $item->comments->count() }})</h3>
                    @foreach ($item->comments as $comment)
                        <div class="comment">
                            <div class="comment-user">{{ $comment->user->name }}</div>
                            <p class="comment-text">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                    <form class="comment-form" action="{{ route('comments.store', $item->id) }}" method="POST">
                        @csrf
                        <label for="content">商品のコメント</label>
                        <textarea id="content" name="content" maxlength="255" required></textarea>
                        @error('content')
                            <p style="color: red;">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="comment-submit">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
