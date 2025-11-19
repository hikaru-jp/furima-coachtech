@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endpush

@section('content')

    <div class="purchase-wrapper">
        <div class="purchase-content">

            <div class="purchase-left">

                <div class="purchase-item">
                    @php use Illuminate\Support\Str; @endphp

                    <div class="item-image-box">
                        @if ($item->img_url)
                            @if (Str::startsWith($item->img_url, 'http'))
                                <img src="{{ $item->img_url }}" alt="商品画像" class="item-image">
                            @else
                                <img src="{{ asset('storage/' . $item->img_url) }}" alt="商品画像" class="item-image">
                            @endif
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="画像なし" class="item-image">
                        @endif

                        <div class="purchase-item-info">
                            <div class="purchase-item-name">{{ $item->name }}</div>
                            <div class="purchase-item-price">¥{{ number_format($item->price) }}</div>
                        </div>
                    </div>
                </div>

                <div class="payment-section">


                    <form action="{{ route('purchase.store', ['item_id' => $item->id]) }}" method="POST" id="address-form">
                        @csrf

                        <label for="payment_method">支払い方法</label>
                        <select name="payment_method" id="payment_method" required>
                            <option value="">選択してください</option>
                            <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>
                                カード支払い
                            </option>
                            <option value="convenience" {{ old('payment_method') == 'convenience' ? 'selected' : '' }}>
                                コンビニ払い
                            </option>
                        </select>

                        <div class="address-section">
                            <label>配送先</label>

                            @if ($address)
                                <p>〒{{ $address->postal_code }}</p>
                                <p>{{ $address->address_line }} {{ $address->building_name }}</p>
                            @else
                                <p>〒未登録</p>
                                <p>住所が登録されていません</p>
                            @endif

                            <a href="{{ route('address.edit', ['item_id' => $item->id]) }}" class="address-change">
                                変更する
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <aside class="purchase-summary">
                <div class="summary-row">
                    <span>商品代金</span>
                    <strong>¥{{ number_format($item->price) }}</strong>
                </div>

                <div class="summary-row">
                    <span>支払い方法</span>
                    <strong id="summary-payment">未選択</strong>
                </div>


                <form action="{{ route('purchase.checkout', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="purchase-btn">購入する</button>
                </form>
            </aside>

        </div>
    </div>

    <script>
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
