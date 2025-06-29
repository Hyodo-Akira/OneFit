@extends('layouts.login_before')
@section('content')

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
    <form method="POST" action="{{ route('signup.confirm') }}">
        @csrf  {{-- セキュリティのためのトークン --}}

        <div>
            <label>名前：</label><br>
            <input type="text" name="name" value="{{ $input['name'] ?? '' }}">
        </div>

        <div>
            <label>メールアドレス：</label><br>
            <input type="email" name="email" value="{{ $input['email'] ?? '' }}">
        </div>

        <div>
            <label>パスワード：</label><br>
            <input type="password" name="password" value="{{ $input['password'] ?? '' }}">
        </div>

        <div>
            <label>パスワード（確認）：</label><br>
            <input type="password" name="password_confirmation" value="{{ $input['password_confirmation'] ?? '' }}">
        </div>

        <div>
            <button type="submit">登録内容確認</button>
        </div>
    </form>

    <p>すでにアカウントをお持ちの方は <a href="{{ route('login') }}">ログイン</a></p>

@endsection