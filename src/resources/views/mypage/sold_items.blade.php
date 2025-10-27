@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
@include('mypage.index') {{-- タブ部分を共通化 --}}

<div class="product-section">
    <h2 class="section-title">出品した商品</h2>

    @if($soldItems->isEmpty())
        <p>出品した商品はありません。</p>
    @else
        <div class="product-grid">
            @foreach($soldItems as $item)
                <div class="product-card">
                     @if ($item->image_path)
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="画像なし">
                    @endif
                   
                    <h5>{{ $item->name }}</h5>
                    <p>出品日：{{ $item->created_at->format('Y/m/d') }}</p>
                    <p>価格：¥{{ number_format($item->price) }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

