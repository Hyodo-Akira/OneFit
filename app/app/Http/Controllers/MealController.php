<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Food;
use App\FoodRecord;


use GuzzleHttp\Client;


class MealController extends Controller
{
    // 食事記録画面を表示する関数
    public function showMealForm()
    {
        // 全ユーザーが登録した食品を取得
        $foods = Food::all(); // 食品リスト取得
        //　foodsという名前でビューに渡す（選択できるようになる）
        return view('meals.meal', compact('foods')); // compact('foods') →　'foods' => $foods と同じ意味
    }

    // 食事記録の保存の関数
    public function recordMeal(Request $request)
    {
        // バリデーションチェック
        $request->validate([
            'date' => 'required|date', // 必須｜日付形式
            'time' => 'required', // 必須
            'food_id' => 'required|exists:foods,id', // 必須｜登録済みの食品でなければならない
            'amount' => 'required|numeric', // 必須｜数字

        ]);
        
        // 入力に問題がなければfood_recordsテーブルに保存
        FoodRecord::create([
            'user_id' => Auth::id(), // ログイン中のユーザーID
            'food_id' => $request->food_id, // 食品のID
            'date' => $request->date, // 食べた日付
            'time' => $request->time, // 食べた時間
            'amount' => $request->amount, // 食べた量（何倍か？）
            'eaten_at' => now(), // 登録日時（現在）

        ]);
    
        // 食事記録画面に戻る
        return redirect()->route('meals.meal');
    }


    // 食品登録画面を表示する関数
    public function showFoodForm()
    {
        // 入力フォームを表示
        return view('meals.food');
    }

    // 登録処理をする関数
    public function recordFood(Request $request)
    {
        // バリデーションチェック
        $request->validate([
            'food_name'     => 'required|max:50',
            'calories' => 'required|numeric',
            'protein'  => 'required|numeric',
            'fat'      => 'required|numeric',
            'carbs'    => 'required|numeric',
        ]);

        Food::create($request->only(['food_name', 'calories', 'protein', 'fat', 'carbs']));

        return redirect()->route('meals.meal');
    }



    // API処理関数
    public function searchFood(Request $request)
    {
        $request->validate([
            'food_name' => 'required|string|max:50'
        ]);

        $searchTerm = $request->food_name;

        $client = new Client();
        $response = $client->get('https://world.openfoodfacts.org/cgi/search.pl', [
            'query' => [
                'search_terms' => $searchTerm,
                'search_simple' => 1,
                'action' => 'process',
                'json' => 1
            ]
        ]);

        $data = json_decode($response->getBody(),true);

        if (empty($data['products'][0]['nutriments'])) {
            return back()->with('error', '該当する食品が見つかりませんでした。');
        }

        $product = $data['products'][0];
        $nutrients = $product['nutriments'];

        return back()->with('search_result', [
            'food_name' => $product['product_name'] ?? $searchTerm,
            'calories'  => $nutrients['energy-kcal_100g'] ?? 0,
            'protein'   => $nutrients['proteins_100g'] ?? 0,
            'fat'       => $nutrients['fat_100g'] ?? 0,
            'carbs'     => $nutrients['carbohydrates_100g'] ?? 0,
        ]);
    }

    public function saveSearchedFood(Request $request)
    {
        $request->validate([
            'food_name' => 'required|string|max:50',
            'calories'  => 'required|numeric',
            'protein'   => 'required|numeric',
            'fat'       => 'required|numeric',
            'carbs'     => 'required|numeric',
        ]);

        Food::create($request->only(['food_name', 'calories', 'protein', 'fat', 'carbs']));

        return redirect()->route('meals.meal')->with('success', '食品を登録しました！');
    }




}
