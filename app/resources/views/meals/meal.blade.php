@extends('layouts.login_after')
@section('content')
<h1>食事記録</h1>

<!-- フォーム送信、送信先 -->
<form method="POST" action="{{ route('meals.record_meal') }}">
    @csrf

    <div>
        <label>日付：</label>
        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}">
    </div>

    <div>
        <label>時刻：</label>
        <input type="time" name="time" value="{{ old('time', date('H:i')) }}">
    </div>

    <div>
        <label>食品名：</label>

        <!-- foods という食品の一覧から、1つを選ぶためのセレクトボックス -->
        <select name="food_id" id="food-select">

            <!-- foreach で foods をループして <option> を1つずつ生成する -->
            @foreach ($foods as $food)
                <!-- value="{{ $food->id }}"：選択した食品の ID を送信 -->
                <!-- data-〇〇：各栄養素の値を埋め込んでおいて、JavaScriptで使うためのもの -->
                <option value="{{ $food->id }}"  
                        data-calories="{{ $food->calories }}"
                        data-protein="{{ $food->protein }}"
                        data-fat="{{ $food->fat }}"
                        data-carbs="{{ $food->carbs }}"
                        {{ $loop->first ? 'selected' : '' }}> <!-- 一番最初の食品をデフォルトで選択状態にする -->
                    {{ $food->food_name }}
                </option>
            @endforeach
        </select>


        <div>
            <label>食べた量 × </label>
            <input type="number" name="amount" value="{{ old('amount') }}" required>
        </div>



        <a href="{{ route('meals.food') }}">新しい食品を登録する</a>
    </div>

    <div>
        <!-- JavaScriptで中の <span> に値が入る -->
        <p>カロリー：<span id="calories">---</span> kcal</p>
        <p>P：<span id="protein">---</span> g
           F：<span id="fat">---</span> g
           C：<span id="carbs">---</span> g</p>
    </div>

    <button type="submit">登録</button>
</form>

<!-- JavaScriptで即時反映 -->
<script>
    // HTMLがすべて読み込まれたら、この中の処理を実行する（ジャバスクリプトはHTMLより先に動くとエラーになることがある）
     document.addEventListener('DOMContentLoaded', function () {
        // select id="food-select" の部分をJavaScriptで操作するために取り出す（どの食品を選んだかを取得するために使う）
        const select = document.getElementById('food-select');
        // input name="amount"　「食べた量を入力する欄」を取得（ユーザーが入力した数（1人前、0.5人前など）を読み取る）
        const amountInput = document.querySelector('input[name="amount"]');

        // 栄養情報を計算して画面に反映するための関数（updateNutrition）を定義する
        function updateNutrition() {
            // selectの中で現在選ばれている <option> を取得
            const selected = select.options[select.selectedIndex];
            // ユーザーが入力した「食べた量（小数）」を数字に変換している。（何も入力されていなければ、0 を使う（エラー回避のため）
            const amount = parseFloat(amountInput.value) || 0;

            // selected.dataset.calories は、HTMLにある data-calories="xxx" の値を読み取る　→　それに amount を掛けて、合計カロリーを求める　→　toFixed(1)：小数点以下1桁にする（例：132.6 kcal）
	•	値が存在しなければ --- と表示する。
            const calories = selected.dataset.calories ? (selected.dataset.calories * amount * 1).toFixed(1) : '---';
            const protein  = selected.dataset.protein  ? (selected.dataset.protein  * amount * 1).toFixed(1) : '---';
            const fat      = selected.dataset.fat      ? (selected.dataset.fat      * amount * 1).toFixed(1) : '---';
            const carbs    = selected.dataset.carbs    ? (selected.dataset.carbs    * amount * 1).toFixed(1) : '---';

            // span id="calories" などの場所に、さっき計算した数字を表示
            document.getElementById('calories').textContent = calories;
            document.getElementById('protein').textContent = protein;
            document.getElementById('fat').textContent = fat;
            document.getElementById('carbs').textContent = carbs;
        }

        // 初期表示
        updateNutrition();

        // 食品変更時
        select.addEventListener('change', updateNutrition);

        // 量変更時
        amountInput.addEventListener('input', updateNutrition);
    });
</script>

@endsection