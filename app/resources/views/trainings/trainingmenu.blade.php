@extends('layouts.login_after')
@section('content')
    <h1>トレーニング種目追加</h1>

    <form method="POST" action="{{ route('trainingmenu.record') }}">
        @csrf

        <div>
            <label for="name">トレーニング種目：</label><br>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <br>
        <button type="submit">登録</button>
    </form>

@endsection