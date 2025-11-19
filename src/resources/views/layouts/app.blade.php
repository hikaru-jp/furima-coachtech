<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>

    <link rel="stylesheet" href="{{ asset('css/app-header.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('css')
</head>

<body>


    <header class="global-header">
        <div class="header-left">
            <a href="{{ route('items.index') }}">
                <img src="{{ asset('images/coachtech-logo.svg') }}" alt="ロゴ" class="header-logo">
            </a>


            <form action="{{ route('items.index') }}" method="GET" class="search-box">
                <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
            </form>
        </div>

        <nav class="header-right">

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">ログアウト</button>
            </form>


            <a href="{{ route('mypage.index') }}" class="menu-link">マイページ</a>


            <a href="{{ route('item.create') }}" class="sell-btn">出品</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>
