<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
//userモデル（DBとつながっている登録編集などの仲介役）を使用
use App\Models\User;

class UserController extends Controller
{
    //編集画面を表示する関数
    public function edit()
    {
        $user = Auth::user(); //ログインしているユーザーのidを取得→$userに代入
        return view('auth.users_edit',['user' => $user]); //$userの情報を元にusers_editに値を代入
    }

    //編集内容でDBを更新させる関数
    public function update(Request $request)
    {
        $request->validate([ //バリデーション
            'name' => 'required|max:20',
            'email' => 'required|email|max:30',
        ]);

        $user = Auth::user();
        $user->update([ //入力内容でアップデート
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        // /homeにリダイレクト、完了メッセージ
        return redirect('/home')->with('success','アカウント情報を変更しました');
    }

    //ログインしているユーザーのアカウントを削除する関数
    public function destroy()
    {
        $user = Auth::user();
        $user->delete();

        // /loginにリダイレクト、完了メッセージ
        return redirect('/login')->with('success','アカウントを削除しました');
    }
}
