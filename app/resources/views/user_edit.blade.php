@extends('layouts.login_after')
@section('content')
    <h1>ユーザー情報編集</h1>
   
    <form action="{{ route('user.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>身長（cm）：</label>
            <input type="number" name="height" value="{{ old('height', $user->height) }}" step="0.1">
        </div>

        <div>
            <label>目標体重（kg）：</label>
            <input type="number" name="weight" value="{{ old('weight', $user->weight) }}" step="0.1">
        </div>

        <div>
            <label>生年月日：</label>
            <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date ?? '') }}">
        </div>

        <div>
            <label>性別：</label>
            <select name="sex">
                <option value="">選択してください</option>
                <option value="男性" {{ old('sex', $user->sex) == '男性' ? 'selected' : '' }}>男性</option>
                <option value="女性" {{ old('sex', $user->sex) == '女性' ? 'selected' : '' }}>女性</option>
            </select>
        </div>

        <div>
            <label>身体活動レベル：</label>
            <select name="pal">
                <option value="">選択してください</option>
                <option value="1.5" {{ old('pal', $user->pal) == '低い' ? 'selected' : '' }}>低い：デスクワーク中心（PAL: 1.5）</option>
                <option value="1.75" {{ old('pal', $user->pal) == '普通' ? 'selected' : '' }}>普通：座って過ごすことが多いが、軽い運動をすることもある（PAL: 1.75）</option>
                <option value="2.0" {{ old('pal', $user->pal) == '高い' ? 'selected' : '' }}>高い：移動や立ち仕事が多く、毎日運動をする習慣がある（PAL: 2.0）</option>
            </select>
        </div>

        <div>
            <label>目標ペース（kg/月）：</label>
            <input type="number" name="target" value="{{ old('target', $user->target) }}" step="0.1">
        </div>

        <button type="submit">更新する</button>
    </form>
        

@endsection