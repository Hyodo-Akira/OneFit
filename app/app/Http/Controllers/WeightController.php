<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Weight;

class WeightController extends Controller
{
    public function showWeightForm()
    {
        return view('weights.weight');
    }


    public  function recordWeight(Request $request)
    {
        // 入力内容のバリデーション
        $request->validate([
            'weight' => 'required|numeric|min:1|max:500',
        ]);

        // バリデーションを通過すればweightに値を追加する
        Weight::create([
            'user_id' => Auth::id(),
            'weight' => $request->weight,
            'date' => now()->toDateString(), // 今日の日付
        ]);

        
        return redirect('main');
    }
}
