@extends('layouts.login_after')
@section('content')
    <h1>体重登録</h1>

    <form method="POST" action="{{ route('weight.record') }}">
        @csrf

        <div>
            <label for="date">日付：</label><br>
            <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required>
        </div>

        <div>
            <label for="weight">体重（kg）：</label><br>
            <input type="number" step="0.1" name="weight" id="weight" value="{{ old('weight') }}" required>
        </div>

        <br>
        <button type="submit">登録</button>
    </form>

@endsection