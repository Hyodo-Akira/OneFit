@extends('layouts.login_before')

@section('content')
<main>
    <h2>登録完了</h2>
    <p>新規登録完了しました。</p>
    <a href="{{ route('login') }}">ログイン画面へ</a>
</main>
@endsection