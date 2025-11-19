@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
    <link rel="stylesheet" href="{{ asset('css/unit-item.css') }}">
@endpush

@section('content')
    <div class="item-list-wrapper">
        <div class="tab-menu">
            <a href="{{ route('items.index', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}"
                class="{{ request('tab') !== 'mylist' ? 'active' : '' }}">
                おすすめ
            </a>
            @if (Auth::check())
                <a href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
                    class="{{ request('tab') === 'mylist' ? 'active' : '' }}">
                    マイリスト
                </a>
            @else
                <span class="tab">マイリスト</span>
            @endif
        </div>
        <div class="item-grid">
            @php use Illuminate\Support\Str; @endphp
            @foreach ($items as $item)
                <div class="item-card">
                    <x-unit-item :item="$item" />
                    @if (in_array($item->id, $myPurchasedItemIds))
                        <span class="sold-label">Sold</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
