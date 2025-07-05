@extends('layouts.login_after')
@section('content')
    <div class="card w-50 mx-auto m-5">
        <div class="card-body">
            <div class="pt-2">
                <p class="h3 border-bottom border-secondary pb-3">プロフィール編集</p>
            </div>
            <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <lavel>プロフィール画像：</lavel>
                <input type="file" name="image">
                @if ($user->image)
                    <div class="mt-2">
                        <p>現在の画像：</p>
                        <img src="{{ asset('storage/profile_images/' . $user->image) }}" alt="プロフィール画像" widdth="150">
                    </div>
                @endif
                
                <br>
                
                <label>名前：</label>
                <input type="text" name="name" value="{{ $user->name }}">

                <br>

                <label>メールアドレス：</label>
                <input type="email" name="email" value="{{ $user->email }}">

                <button type="submit">更新</button>
            </form>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">アカウント削除</button>
            </form>
        </div>
    </div>
@endsection
