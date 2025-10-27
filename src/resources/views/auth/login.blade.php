@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endpush

@section('content')
    <div class="login-wrapper">
        <h1 class="login-title">ログイン</h1>


        @if (session('status'))
            <p class="error-message">{{ session('status') }}</p>
        @endif

        <form action="{{ route('login') }}" method="POST" class="login-form">
            @csrf


            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" placeholder="example@example.com"
                    value="{{ old('email') }}">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>


            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password" placeholder="8文字以上">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="login-btn">ログインする</button>
        </form>

        <p class="register-link">
            <a href="{{ route('register') }}">会員登録はこちら</a>
        </p>
    </div>
@endsection
