<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OneFit') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('stylesheet')
</head>
<body>
    <div id="app">

        <!-- アプリロゴ -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('main') }}">
                    OneFit
                </a>
            </div>

            <!-- プロフィール画像 -->
            <a href="{{ route('mypage') }}">
                <img src="{{ asset('storage/profile_images/' . Auth::user()->image) }}"
                     alt="プロフィール画像"
                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-link" onclick="event.preventDefault(); confirmLogout();">ログアウト</button>
            </form>
        </nav>
        <script>
            function confirmLogout() {
                if (confirm('本当にログアウトしますか？')) {
                    document.getElementById('logout-form').submit();
                }
            }
        </script>
        @yield('content')
    </div>
</body>
</html>