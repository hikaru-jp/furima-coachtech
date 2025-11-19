@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/item-create.css') }}">
@endpush

@section('content')
    <div class="item-create-wrapper">
        <h1 class="item-create-title">商品の出品</h1>

        <form class="item-create-form" method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="image-upload">
                <label for="item_image">画像を選択する</label>
                <input type="file" id="item_image" name="item_image">
            </div>

            <div>
                <label for="categories">商品の詳細</label>
                <div class="category-section">
                    @foreach ($categories as $category)
                        <label class="category-item">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="select-section">
                <label for="condition">商品の状態</label>
                <select id="condition" name="condition">
                    <option value="">選択してください</option>
                    <option value="new">良好</option>
                    <option value="like-new">目立った傷や汚れなし</option>
                    <option value="used">やや傷や汚れあり</option>
                    <option value="bad">状態が悪い</option>
                </select>
            </div>

            <div>
                <label for="name">商品名</label>
                <input type="text" id="name" name="name" placeholder="商品名を入力してください">
            </div>
            <div>
                <label for="brand">ブランド名</label>
                <input type="text" id="brand" name="brand" placeholder="ブランド名を入力してください">
            </div>
            <div>
                <label for="description">商品の説明</label>
                <textarea id="description" name="description" placeholder="商品の特徴や状態を入力してください"></textarea>
            </div>

            <div>
                <label for="price">販売価格</label>
                <input type="number" id="price" name="price" placeholder="¥">
            </div>

            <button type="submit" class="item-create-submit">出品する</button>
        </form>
    </div>
@endsection
