<?php


// トップページ表示の際のAuth::check()機能使用のための宣言
use Illuminate\Support\Facades\Auth;
//Auth(認証機能（新規登録やログイン、ログアウトをまとめたもの）)Controllerを使う宣言　※名前は自由に決められるもの
use App\Http\Controllers\AuthController;
//ユーザーの登録情報などの編集・削除などを行うコントローラーを使う宣言
use App\Http\Controllers\UserController;
//ミドルウェアのAuthenticateを使う宣言（ログインしていない人がメインページにアクセスしたときにログインページへ飛ばす）
use App\Http\middleware\Authenticate;

use App\Http\Controllers\MealController;

use App\Http\Controllers\WeightController;

use App\Http\Controllers\TrainingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ルートのGET、POST、PUT、DELETE　などは、それぞれ 「何を目的とした通信か」 によって使い分ける
//　GET　　　   ・・・データの取得（表示)　→　ページ表示、詳細確認
//　POST　　　  ・・・新規作成　　　　　　 →　フォーム送信、ユーザー登録
//　PUT / PATCH・・・更新（変更）　　　　 →　ユーザー情報の編集・上書き
//　DELETE　　　・・・削除　　　　　　　　 →　ユーザー削除


// 最初の画面表示　/ にアクセスされたときにログインしているかを確認（Auth::check()はララベルの組み込み関数）
// ログインしていればメイン画面を表示、していなければログイン画面を表示
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('main');
    }
    return redirect()->route('login');
});


// メイン画面を表示するための関数　ミドルウェアを用いてログインしていない人にはメインページを表示させないようにしている（ログインページへ遷移する（ミドルウェア関数で定義））
Route::get('/main',[AuthController::class,'showMainForm'])->middleware('auth')->name('main');


// 新規登録ページ表示関数
Route::get('/signup',[AuthController::class,'showSignupForm'])->name('signup');
// 登録内容確認画面へのデータ送信関数
Route::Post('/signup/confirm',[Authcontroller::class,'confirmSignup'])->name('signup.confirm');
//登録内容を登録ページに残しておく関数（修正ボタン）
Route::get('/signup/edit', [AuthController::class, 'showSignupForm'])->name('signup.edit');
//signupのcompleteにアクセスしたらAuthControllerにあるcompleteSignup関数を使う→これをsignup.completeで使える　※登録処理
Route::post('/signup/complete',[AuthController::class,'completeSignup'])->name('signup.complete');

//loginにアクセスしたらAuthControllerにあるshowLoginForm関数を使う→このルートをloginで使える
Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
//ログインボタンを押したときloginという関数を使う
Route::post('/login',[AuthController::class,'login']);

//ログアウトしたいときのルート、ボタンを押したときlogout関数を使う→このルートをlogoutで使える
Route::Post('/logout',[AuthController::class,'logout'])->name('logout');


// マイページ表示用ルート
Route::get('/mypage',[UserController::class,'showMypage'])->name('mypage');

//編集したいユーザーの編集ページに移動、UsersControllerのeditクラスを使う→users.editで使える
Route::get('users_edit',[UserController::class,'edit'])->name('users.edit');
//データを上書きするときに使うルート（どのユーザーのデータを更新するか）、UserControllerのupdateクラスを使う→users.updateで使える
Route::put('/users_edit',[UserController::class,'update'])->name('users.update');
//データを削除するときに使うルート（どのユーザーのデータを削除するか）、UserControllerのdestroyクラスを使う→users.destroyで使える
Route::delete('/users_edit',[UserController::class,'destroy'])->name('users.destroy');


// ユーザー情報編集ページ表示（身長体重、目標など）
Route::get('/user_edit',[UserController::class,'showUserEdit'])->name('user.edit');
// ユーザー情報を更新する場合
Route::put('/user_edit',[UserController::class,'userUpdate'])->name('user.update');


//パスワード再設定用処理まとめ
Route::prefix('reset')->group(function(){
    //パスワード再設定用のメール送信フォーム
    Route::get('/',[UserController::class,'requestResetPasswordMail'])->name('reset.form');
    //メール送信処理
    Route::post('/send',[UserController::class,'sendResetPasswordMail'])->name('reset.send');
    // メール送信完了
    Route::get('/send/complete',[UserController::class,'sendCompleteResetPasswordMail'])->name('reset.send.complete');
    // パスワード再設定
    Route::get('/password/edit',[UserController::class,'resetPassword'])->name('reset.password.edit');
    // パスワード更新
    Route::post('/password/update',[UserController::class,'updatePassword'])->name('reset.password.update');
});



// 食事記録画面を表示
Route::get('/meals.meal',[MealController::class,'showMealForm'])->name('meals.meal');
// 食事記録の保存処理
Route::post('/meals.meal',[MealController::class,'recordMeal'])->name('meals.record_meal');
// 食品登録ページを表示
Route::get('/meals.food',[MealController::class,'showFoodForm'])->name('meals.food');
// 食品を登録
Route::post('/meals.food',[MealController::class,'recordFood'])->name('meals.record_food');




// 食品検索API
Route::post('/meals/search', [MealController::class, 'searchFood'])->name('meals.search');

// 検索結果を登録
Route::post('/meals/save-result', [MealController::class, 'saveSearchedFood'])->name('meals.food.saveResult');





// 体重記録画面を表示
Route::get('/weights.weight',[WeightController::class,'showWeightForm'])->name('weights.weight');
// 体重の保存処理
Route::post('/weight.weight',[WeightController::class,'recordWeight'])->name('weight.record');



// トレーニング記録画面表示
Route::get('/trainings.training',[TrainingController::class,'showTrainingForm'])->name('trainings.training');
// トレーニング記録保存
Route::post('trainings.training',[TrainingController::class,'recordTraining'])->name('training.record');


// トレーニングメニュー追加画面表示
Route::get('/trainings.trainingmenu',[TrainingController::class,'showTrainingMenuForm'])->name('trainings.trainingmenu');

Route::post('trainings.trainingmenu',[TrainingController::class,'recordTrainingMenu'])->name('trainingmenu.record');