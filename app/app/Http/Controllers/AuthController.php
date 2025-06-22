<?php

//ディレクトリの場所
namespace App\Http\Controllers;

//リクエストの情報を使えるようにする
use Illuminate\Http\Request;

//ララベルに備わっているログインの仕組みをAuthという道具を使って操作する
use Illuminate\Support\Facades\Auth;

//パスワードをハッシュ化（安全な形で保存）するための道具を使う
use Illuminate\Support\Facades\Hash;

//DBのusersテーブルとつながっているクラス（User）を使う
use App\Models\User;


class AuthController extends Controller
{   
    //ログイン画面を表示する指示
    public function showLoginForm() 
    {
        return view('auth.login'); //resources/views/auth/login.blade.phpを表示
    }

    //ログイン処理をする関数
    public function login(Request $request)
    {
        //$requestの内容をバリデーションし、$loginDataに代入する
        $loginData=$request->validate([
            'email' => ['required','email'], //required=入力必須、email=正しいメールアドレス形式か
            'password' => ['required'], //入力必須
        ]);

        //もし$loginDataの中身と同じものがあれば（Auth::attemptはユーザーが正しいが確認する関数）
        if(Auth::attempt($loginData)) {
            $request->session()->regenerate(); //$request->session()画面変異などでもログイン情報を残す。->regenerate()新しいセッションIDを作成しセキュリティ強化
            return redirect('/home'); //　/homeにリダイレクト
        }
        //失敗したら元の画面に戻す。withErrors→エラーやエラーメッセージを次の画面に渡す機能
        return back()->withErrors([
            'email' => 'メールアドレスかパスワードが正しくありません', //email入力欄にエラーメッセージを表示
        ]);
    }

    //新規登録画面を表示する関数
    public function showRegisterForm()
    {
        return view('auth.register'); //register.blade.phpを表示
    }

    //新規登録処理を行う関数
    public function register(Request $request)
    {
        //入力内容のバリデーションチェック
        $request->validate([
            'name' => 'required|max:20', //必須、20文字以内
            'email' => 'required|email|max:30', //必須、正しいメール方式
            'password' => 'required|min:6' //必須、6文字以上（安全のため）
        ]);
        //Userモデルを使ってあたらしいデータを作る
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), //セキュリティ保護のためハッシュ化して保存
        ]);

        return redirect()->route('login');
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
