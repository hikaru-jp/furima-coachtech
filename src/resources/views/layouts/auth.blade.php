<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>

    <link rel="stylesheet" href="{{ asset('css/auth-header.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    @stack('css')
</head>

<body>
    <header class="global-header">
        <div class="header-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/coachtech-logo.svg') }}" alt="COACHTECHロゴ">
            </a>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>
