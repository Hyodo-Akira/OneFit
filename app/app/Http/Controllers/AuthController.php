<?php

// ファイル存在する場所
namespace App\Http\Controllers;

//リクエストの情報を使えるようにする
use Illuminate\Http\Request;

//ララベルに備わっているログインの仕組みをAuthという道具を使って操作する
use Illuminate\Support\Facades\Auth;

//パスワードをハッシュ化（安全な形で保存）するための道具を使う
use Illuminate\Support\Facades\Hash;

//DBのusersテーブルとつながっているクラス（User）を使う
use App\Models\User;


use Carbon\Carbon;


use App\FoodRecord;


class AuthController extends Controller
{   
    // ログイン画面を表示する指示
    public function showLoginForm() 
    {
        // resources/views/auth/login.blade.phpを表示
        return view('auth.login'); 
    }



    // メイン画面を表示する関数
    public function showMainForm()
    {
        //ログインしたユーザーの情報を取得し$userに代入
        $user = Auth::user();


        $today = Carbon::today();

        $todayrecords = FoodRecord::with('food')
            ->where('user_id', $user->id)
            ->whereDate('date', $today)
            ->get();

        // 合計値の初期化
        $totalCalories = 0;
        $totalProtein = 0;
        $totalFat = 0;
        $totalCarbs = 0;

        // 各記録に対して合計値を算出
        foreach ($todayrecords as $record) {
            $amount = $record->amount; // 食べた量（単位：倍）
            $food = $record->food;

            $totalCalories += $food->calories * $amount;
            $totalProtein += $food->protein * $amount;
            $totalFat     += $food->fat * $amount;
            $totalCarbs   += $food->carbs * $amount;
        }

        return view('main', [
            'totalCalories' => round($totalCalories),
            'totalProtein' => round($totalProtein, 1),
            'totalFat' => round($totalFat, 1),
            'totalCarbs' => round($totalCarbs, 1),
            'targetCalories' => $user->target_calories ?? 2000, // 目標なければ仮で2000
        ]);
    }



    //ログイン処理をする関数　フォームからの送信データを$requestで受け取っている
    public function login(Request $request)
    {
        //$requestの内容をバリデーションし、$loginDataに代入する
        $loginData=$request->validate([
            // 以下にバリデーションのルールを記載
            'email' => ['required','email'], //required=入力必須、email=正しいメールアドレス形式か
            'password' => ['required'], //入力必須
        ]);

        //　もし$loginDataの中身と同じものがあれば（Auth::attemptはユーザーが正しいか確認する関数）
        if(Auth::attempt($loginData)) {
            $request->session(); //$request->session()画面変異などでもログイン情報を残す
            return redirect('/main'); //　/mainにリダイレクト
        }
        //失敗したら元の画面に戻す。withErrors→エラーやエラーメッセージを次の画面に渡す機能
        return back()->withErrors([
            'email' => 'メールアドレスかパスワードが正しくありません', //email入力欄にエラーメッセージを表示
        ]);
    }



    //新規登録画面を表示する関数
    public function showSignupForm(Request $request)
    {
        // $request->session()　現在のセッション（一時的な保存領域）にアクセス　
        // ->get('signup_input', []) セッションからsignup_inputという名前のデータを取得、なければ空の配列を返す
        // $input 上記を代入　※入力確認ページから戻ってきた際の入力保持用
        $input = $request->session()->get('signup_input', []);

        // signup.blade.phpを表示
        // compact('input') $input という変数をビューに渡す(ビューの中で{{ $input['name'] }} のように使えるようになる)
        return view('auth.signup', compact('input')); 
    }



    //新規登録処理を行う関数
    public function confirmSignup(Request $request)
    {
        //入力内容のバリデーションチェック
        $request->validate([
            'name' => 'required|max:20', //必須、20文字以内
            'email' => 'required|email|max:30', //必須、正しいメール方式
            'password' => 'required|min:6' //必須、6文字以上（安全のため）
        ]);

        // 入力内容$requestをセッションに保存し signup_input という名前で保存
        $request->session()->put('signup_input');
        // $inputに$requestの内容を代入（修正ボタンで戻ったときに入力値を保存しておくため）
        $input = $request->all();

        // 確認画面を表示、$inputという変数がビューで使用できるようにする
        return view('auth.signup_confirm',compact('input'));
    }




    public function completeSignup(Request $request)
    {
        //Userモデルを使ってあたらしいデータを作る
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), //セキュリティ保護のためハッシュ化して保存
        ]);

        // セッションの削除
        $request->session()->forget('signup_input');


        return view('auth.signup_complete');
    }

    //ログアウト機能関数
    public function logout(Request $request)
    {
        //ログアウト処理
        Auth::logout();

        $request->session()->invalidate(); //現在のログイン情報（セッション）を無効化　※セッション＝本人証明のようなもの
        $request->session()->regenerateToken(); //次の安全なフォーム送信用トークンを作成　※トークン＝フォーム送信のときに使用する合言葉

        return redirect('/login'); //ログイン画面へリダイレクト
    }

}
