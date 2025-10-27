@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}?v={{ time() }}">

@endpush

@section('content')
<div class="register-wrapper">
    <h1 class="register-title">会員登録</h1>

    <form action="{{ route('register') }}" method="POST" class="register-form" novalidate>

        @csrf

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" id="name" placeholder="例：山田太郎" required>
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" placeholder="example@example.com" required>
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password" placeholder="8文字以上" required>
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">確認用パスワード</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button type="submit" class="register-btn">登録する</button>
    </form>

    <p class="login-link">
        <a href="{{ route('login') }}">ログインはこちら</a>
    </p>
</div>
@endsection
