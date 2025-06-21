<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h1>ログイン</h1>

    <!-- エラーメッセージ表示 -->
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ログインフォーム -->
    <form method="POST" action="/login">
        @csrf

        <label for="email">メールアドレス：</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">パスワード：</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">ログイン</button>
    </form>
</body>
</html>