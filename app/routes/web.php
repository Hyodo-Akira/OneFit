<?php

//Auth(認証機能（新規登録やログイン、ログアウトをまとめたもの）)Controllerを使う宣言　※名前は自由に決められるもの
use App\Http\Controllers\AuthController;

use App\Http\Controllers\UserController;

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

Route::get('/home', function () {
    return view('home');
})->name('home');

//registerにアクセスしたらAuthControllerにあるshowRegisterForm関数を使う→このルートをregisterで使える
Route::get('/register',[AuthController::class,'showRegisterForm'])->name('register');
//登録ボタンを押したとき（POSTはデータを送るときにつかう）registerという関数を使う
Route::post('/register',[AuthController::class,'register']);

//loginにアクセスしたらAuthControllerにあるshowLoginForm関数を使う→このルートをloginで使える
Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
//ログインボタンを押したときloginという関数を使う
Route::post('/login',[AuthController::class,'login']);

//ログアウトしたいときのルート、ボタンを押したときlogout関数を使う→このルートをlogoutで使える
Route::Post('/logout',[AuthController::class,'logout'])->name('logout');

//編集したいユーザーの編集ページに移動、UsersControllerのeditクラスを使う→users.editで使える
Route::get('users/{id}/edit',[UserController::class,'edit'])->name('users.edit');
//データを上書きするときに使うルート（どのユーザーのデータを更新するか）、UserControllerのupdateクラスを使う→users.updateで使える
Route::put('/users/{id}',[UserController::class,'update'])->name('users.update');
//データを削除するときに使うルート（どのユーザーのデータを削除するか）、UserControllerのdestroyクラスを使う→users.destroyで使える
Route::delete('/users/{id}',[UserController::class,'destroy'])->name('users.destroy');

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