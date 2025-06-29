@extends('layouts.login_after')
@section('content')
    <h1>食品登録</h1>

    <!-- フォーム送信、meals.record_foodにデータを送る -->
    <form method="POST" action="{{ route('meals.record_food') }}">

    <!-- フォーム送信時のセキュリティ対策（送信時必須） -->
    @csrf

    <div>
        <label for="food_name">食品名：</label><br>

        <!-- 文字入力、コントローラーに送るキー名、前回送信時の値を保持（バリデーションエラー時に便利）、入力必須 -->
        <input type="text" name="food_name" id="food_name" value="{{ old('food_name') }}" required>
    </div>

    <div>
        <label for="calories">カロリー（kcal）：</label><br>
        <input type="number" step="0.1" name="calories" id="calories" value="{{ old('calories') }}" required>
    </div>

    <div>
        <label for="protein">たんぱく質（g）：</label><br>
        <!-- 数値入力、小数点1位まで対応 -->
        <input type="number" step="0.1" name="protein" id="protein" value="{{ old('protein') }}" required>
    </div>

    <div>
        <label for="fat">脂質（g）：</label><br>
        <input type="number" step="0.1" name="fat" id="fat" value="{{ old('fat') }}" required>
    </div>

    <div>
        <label for="carbs">炭水化物（g）：</label><br>
        <input type="number" step="0.1" name="carbs" id="carbs" value="{{ old('carbs') }}" required>
    </div>

    <br>
    <button type="submit">登録する</button>
</form>

@endsection