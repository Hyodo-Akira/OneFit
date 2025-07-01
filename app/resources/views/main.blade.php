@extends('layouts.login_after')
@section('content')



    <form method="POST" action="/date">
        @csrf
        <p>データ検索</p>
        <label for="date">日付：</label><br>
        <input type="date" id="date" name="date" required><br><br>

        <button type="submit">検索</button>
    </form>


    
    <div>
        <p>本日の接種カロリー</p>
        
            <p>{{ $totalCalories }} kcal / 目標：{{ $targetCalories }} kcal</p>
            <p>P：{{ $totalProtein }} g  F：{{ $totalFat }} g  C：{{ $totalCarbs }} g</p>
        
        <form action="{{ route('meals.meal') }}">
            <button type="submit">食事を記録する</button>
        </form>
    </div>




    <div>
        <p>体重管理</p>

        <p>目標体重：{{ $targetWeight ?? '未設定' }} kg</p>

        <p>今日の体重：
            {{ $todayWeight !== null ? $todayWeight . ' kg' : '未記録' }}
        </p>

        @if($targetWeight && $todayWeight !== null)
            <p>目標まであと：{{ abs($targetWeight - $todayWeight) }} kg</p>
        @endif

        <form action="{{ route('weights.weight') }}">
            <button type="submit">体重を記録する</button>
        </form>
    </div>




    <div>
        <p>本日のトレーニング記録</p>

        @if($todayTraining->isEmpty())
            <p>本日の記録はありません。</p>
        @else
            <ul>
                @foreach ($todayTraining as $training)
                    <li>
                        @for ($i = 1; $i <= 10; $i++)
                            @php
                                $rep = $training["rep$i"];
                                $weight = $training["weight$i"];
                            @endphp

                            @if (!is_null($rep) || !is_null($weight))
                                セット{{ $i }}：{{ $rep ?? '---' }}回 × {{ $weight ?? '---' }}kg<br>
                            @endif
                        @endfor
                    </li>
                    <hr>
                @endforeach
            </ul>
        @endif

        <!-- トレーニング記録ボタン -->
        <form action="{{ route('trainings.training') }}">
            <button type="submit">トレーニングを記録する</button>
        </form>
    </div> 
@endsection