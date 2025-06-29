@extends('layouts.login_before')
@section('content')
<main>
    <h2>パスワード再設定</h2>
    <p>ご利用中のメールアドレスを入力してください</p>
    <p>パスワード再設定のためのURLをお送りします</p>
    <form method="POST" action="{{ route('reset.send') }}">
        @csrf
        <div>
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
            <span>{{ $errors->first('email') }}</span>
        </div>
        <div>
            <a href="{{ route('login') }}">戻る</a>
            <button type="submit">再設定メールを送信</button>
        </div>
    </form>
</main>
@endsection