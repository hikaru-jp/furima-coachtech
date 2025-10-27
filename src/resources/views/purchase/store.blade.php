@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endpush

@section('content')
    <div class="purchase-wrapper">

        <!-- ヘッダー -->
        <header class="header">

            <div class="header-search">
                <input type="text" placeholder="なにをお探しですか？">
            </div>

            <nav class="header-menu">
                <a href="{{ route('logout') }}">ログアウト</a>
                <a href="{{ route('mypage.index') }}">マイページ</a>
                <a href="{{ route('item.create') }}">出品</a>
            </nav>
        </header>

        <!-- 購入 -->
        <div class="purchase-content">

            <!-- 商品情報・支払い・住所 -->
            <div class="purchase-left">
                <!-- 商品情報 -->
                <div class="purchase-item">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                    <div class="purchase-item-info">
                        <div class="purchase-item-name">{{ $item->name }}</div>
                        <div class="purchase-item-price">¥{{ number_format($item->price) }}</div>
                    </div>
                </div>

                <!-- 支払い方法 -->
                <div class="payment-section">
                    <form action="{{ route('purchase.store', $item->id) }}" method="POST">
                        @csrf

                        <label for="payment_method">支払い方法</label>
                        <select name="payment_method" id="payment_method" required>
                            <option value="">選択してください</option>
                            <option value="credit">カード支払い</option>
                            <option value="convenience">コンビニ払い</option>

                        </select>

                        <!-- 配送先 -->
                        <div class="address-section">
                            <label>配送先</label>
                            <p>〒{{ Auth::user()->postal_code ?? 'XXX-YYYY' }}</p>
                            <p>{{ Auth::user()->address ?? 'ここには住所と建物が入ります' }}</p>
                            <a href="{{ route('address.edit', $item->id) }}" class="address-change">変更する</a>
                        </div>

                        <button type="submit" class="purchase-btn">購入する</button>
                    </form>
                </div>
            </div>

            <!-- 購入内容 -->
            <aside class="purchase-summary">
                <h3>購入内容</h3>

                <div class="summary-row">
                    <span>商品代金</span>
                    <strong>¥{{ number_format($item->price) }}</strong>
                </div>

                <div class="summary-row">
                    <span>支払い方法</span>
                    <strong id="summary-payment">未選択</strong>
                </div>

                <button class="purchase-btn" form="payment_form">購入する</button>
            </aside>

        </div>
    </div>

    <script>
        // 支払い方法選択 
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('payment_method');
            const summary = document.getElementById('summary-payment');
            if (select) {
                select.addEventListener('change', () => {
                    summary.textContent = select.options[select.selectedIndex].text;
                });
            }
        });
    </script>
@endsection
