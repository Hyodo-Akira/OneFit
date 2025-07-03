@extends('layouts.login_after')

@section('content')
<h1>マイページ</h1>

<div class="profile-box">
    <img src="{{ asset('storage/icons/' . ($user->image ?? 'default.png')) }}" alt="ユーザー画像" width="120">
    <h3>{{ $user->name }}</h3>

    <a href="{{ route('users.edit',['id' => $user->id]) }}">アカウント編集・削除</a>

    <br>

    <p>称号：{{ $user->title ?? '---' }}</p>
    <p>フィットコイン：{{ $user->fitcoin ?? 0 }} FitCoin</p>

    <hr>

    <p>身長：{{ $user->height ?? '---' }} cm</p>
    <p>目標体重：{{ $user->weight ?? '---' }} kg</p>
    <p>年齢：{{ $age ?? '---' }} 歳</p>
    <p>性別：{{ $user->sex ?? '---' }}</p>
    <p>身体活動レベル：{{ $user->pal ?? '---' }}</p>
    <p>目標ペース：-{{ $user->target ?? '---' }}kg/月</p>

    <a href="{{ route('user.edit') }}">ユーザー情報編集</a>
    
</div>
@endsection