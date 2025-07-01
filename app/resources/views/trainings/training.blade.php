@extends('layouts.login_after')
@section('content')
<p>トレーニング記録</p>

<form method="POST" action="{{ route('training.record') }}">
    @csrf

    <label>日付：</label>
    <input type="date" name="date" value="{{ date('Y-m-d') }}" required><br>

    <label>種目：</label>
    <input type="text" name="menu" required><br>

    <label>部位：</label>
    <input type="text" name="parts" required><br>

    

    @for ($i = 1; $i <= 10; $i++)
        <label>{{ $i }}セット目：</label>
        
        <input type="number" name="weight{{ $i }}" placeholder="重さ(kg)" step="0.1" min="0">kg

        <input type="number" name="rep{{ $i }}" placeholder="回数" min="0">回<br>

    @endfor

    <button type="submit">記録する</button>
</form>

@endsection