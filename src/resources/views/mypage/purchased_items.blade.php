@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
@include('mypage.index') {{-- タブ部分を共通化 --}}

<div class="product-section">
    <h2 class="section-title">購入した商品</h2>

    @if($purchasedItems->isEmpty())
        <p>購入した商品はありません。</p>
    @else
        <div class="product-grid">
            @foreach($purchasedItems as $purchase)
                <div class="product-card">
                     @if ($purchase->item && $purchase->item->image_path)
                        <img src="{{ asset('storage/' . $purchase->item->image_path) }}" alt="商品画像">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="画像なし">
                    @endif
                    
                    <h5>{{ $purchase->item->name }}</h5>
                    <p>購入日：{{ $purchase->created_at->format('Y/m/d') }}</p>
                    <p>価格：¥{{ number_format($purchase->item->price) }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
