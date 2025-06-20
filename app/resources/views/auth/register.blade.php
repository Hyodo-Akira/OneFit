<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>
    <h1>新規登録</h1>

    <!-- 登録エラーがあれば表示 -->
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>  {{-- エラーメッセージを表示 --}}
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 新規登録フォーム -->
    <form method="POST" action="{{ route('register') }}">
        @csrf  {{-- セキュリティのためのトークン --}}

        <div>
            <label>名前：</label><br>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            <label>メールアドレス：</label><br>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            <label>パスワード：</label><br>
            <input type="password" name="password">
        </div>

        <div>
            <label>パスワード（確認）：</label><br>
            <input type="password" name="password_confirmation">
        </div>

        <div>
            <button type="submit">登録する</button>
        </div>
    </form>

    <p>すでにアカウントをお持ちの方は <a href="{{ route('login') }}">ログイン</a></p>
</body>
</html>