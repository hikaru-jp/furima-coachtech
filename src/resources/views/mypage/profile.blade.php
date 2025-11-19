@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
@endpush

@section('content')
    <div class="profile-edit-wrapper">
        <h1 class="profile-edit-title">プロフィール設定</h1>

        <div class="profile-edit-icon">
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
            <label for="profile_image">画像を選択する</label>
        </div>

        <form class="profile-edit-form" action="{{ route('mypage.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="file" id="profile_image" name="profile_image" style="display:none;">

            <div>
                <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>

            <div>
                <label for="postal_code">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code"
                    value="{{ old('postal_code', optional($user->address)->postal_code) }}">
            </div>

            <div>
                <label for="address_line">住所</label>
                <input type="text" id="address_line" name="address_line"
                    value="{{ old('address_line', optional($user->address)->address_line) }}">
            </div>

            <div>
                <label for="building_name">建物名</label>
                <input type="text" id="building_name" name="building_name"
                    value="{{ old('building_name', optional($user->address)->building_name) }}">
            </div>

            <button type="submit" class="profile-edit-submit">更新する</button>
        </form>
    </div>
@endsection
