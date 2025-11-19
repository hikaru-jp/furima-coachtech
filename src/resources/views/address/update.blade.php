@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/address-edit.css') }}">
@endpush

@section('content')
    <div class="address-edit-wrapper">

        <h1 class="address-edit-title">住所の変更</h1>

        <form class="address-edit-form" action="{{ route('address.update', ['item_id' => $item_id]) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="item_id" value="{{ $item_id }}">

            <div>
                <label for="postal_code">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code"
                    value="{{ old('postal_code', $address->postal_code ?? '') }}" placeholder="例）123-4567">
            </div>
            <div>
                <label for="address_line">住所</label>
                <input type="text" id="address_line" name="address_line"
                    value="{{ old('address_line', $address->address_line ?? '') }}" placeholder="例）東京都中央区築地１丁目２番３号">
            </div>

            <div>
                <label for="building_name">建物名</label>
                <input type="text" id="building_name" name="building_name"
                    value="{{ old('building_name', $address->building_name ?? '') }}" placeholder="例）中央テラスビル101">
            </div>

            <button type="submit" class="address-edit-submit">更新する</button>
        </form>
    </div>
@endsection
