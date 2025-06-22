@extends('layouts.layout')
@section('content')
    <div class="card w-50 mx-auto m-5">
        <div class="card-body">
            <div class="pt-2">
                <p class="h3 border-bottom border-secondary pb-3">プロフィール編集</p>
            </div>
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <label>名前：</label>
                <input type="text" name="name" value="{{ $user->name }}">

                <label>メールアドレス：</label>
                <input type="email" name="email" value="{{ $user->email }}">

                <button type="submit">更新</button>
            </form>
        </div>
    </div>
@endsection
