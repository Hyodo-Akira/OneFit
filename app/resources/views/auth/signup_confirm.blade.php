@extends('layouts.login_before')
@section('content')

<h1>新規登録内容確認</h1>


<form method="POST" action="{{ route('signup.complete') }}">
    @csrf
    <p>名前: {{ $input['name'] }}</p>
    <input type="hidden" name="name" value="{{ $input['name'] }}">

    <p>メール: {{ $input['email'] }}</p>
    <input type="hidden" name="email" value="{{ $input['email'] }}">

    <p>パスワード:{{ $input['password'] }}</p>
    <input type="hidden" name="password" value="{{ $input['password'] }}">
    <input type="hidden" name="password_confirmation" value="{{ $input['password_confirmation'] }}">
    <button type="submit">登録</button>
</form>
<form method="GET" action="{{ route('signup.edit') }}">
    <button type="submit">修正する</button>
</form>

@endsection