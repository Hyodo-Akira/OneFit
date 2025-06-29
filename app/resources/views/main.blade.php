@extends('layouts.login_after')
@section('content')



    <form method="POST" action="/date">
        @csrf
        <p>データ検索</p>
        <label for="date">日付：</label><br>
        <input type="date" id="date" name="date" required><br><br>

        <button type="submit">検索</button>
    </form>


    

    <form method="POST" action="/date">
        @csrf
        <p>本日の接種カロリー</p>
        
            <p>{{ $totalCalories }} kcal / 目標：{{ $targetCalories }} kcal</p>
            <p>P：{{ $totalProtein }} g  F：{{ $totalFat }} g  C：{{ $totalCarbs }} g</p>
        

        <a href="{{ route('meals.meal') }}">食事を記録する</a>
    </form>
   
@endsection