<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
//userモデル（DBとつながっている登録編集などの仲介役）を使用
use App\Models\User;
use App\Models\PasswordReset;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\ResetInputMailRequest;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // マイページを表示する関数
    public function showMypage()
    {

        $user = Auth::user();

        return view('mypage',compact('user'));
    }


    public function showMypageEdit()
    {
        return view('');
    }

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
        
        // /mainにリダイレクト、完了メッセージ
        return redirect('/main')->with('success','アカウント情報を変更しました');
    }

    //ログインしているユーザーのアカウントを削除する関数
    public function destroy()
    {
        $user = Auth::user();
        $user->delete();

        // /loginにリダイレクト、完了メッセージ
        return redirect('/login')->with('success','アカウントを削除しました');
    }


    // ユーザー情報編集画面表示関数
    public function showUserEdit()
    {
        return view('user_edit');
    }

    public function userUpdate()
    {
        
    }



    private $userRepository;
    private const MAIL_SENDED_SESSION_KEY = 'user_reset_password_mail_sended_action';

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // パスワード再設定用のメール送信フォーム表示する関数
    public function requestResetPasswordMail()
    {
        return view('auth.pwd_reset');
    }

    // メール送信関数　フォームから送られてきたメールアドレスを受け取って処理する関数
    public function sendResetPasswordMail(ResetInputMailRequest $request)
    {
        //この処理が失敗した場合はcatchに進む
        try {
            // ユーザー情報取得 userRepositoryで定義したfindFromMailを使ってemailでユーザーを探す
            $user = $this->userRepository->findFromMail($request->email);
            //パスワード再設定用のトークン（鍵）を作る
            $passwordReset = $this->userRepository->updateOrCreateUser($user->email);
            // メール送信
            Mail::send(new ResetPasswordMail($user, $passwordReset));
        } catch(Exception $e) {
            return redirect()->route('reset.form')
                ->with('flash_message', '処理に失敗しました。時間をおいて再度お試しください。');
        }
        // 不正アクセス防止セッションキー
        session()->put(self::MAIL_SENDED_SESSION_KEY, 'user_reset_password_send_email');
    
        return redirect()->route('reset.send.complete');
    }
    // メール送信完了
    public function sendCompleteResetPasswordMail()
    {
        // 不正アクセス防止セッションキーを持っていない場合
        if (session()->pull(self::MAIL_SENDED_SESSION_KEY) !== 'user_reset_password_send_email') {
            return redirect()->route('reset.form')
                ->with('flash_message', '不正なリクエストです。');
        }
        return view('auth.reset_input_mail_complete');
    }
    // パスワード再設定
    public function resetPassword(Request $request)
    {
        // 署名付きURLではない場合
    	if (!$request->hasValidSignature()) {
            abort(403, 'URLの有効期限が過ぎたためエラーが発生しました。パスワード再設定メールを再発行してください。');
        }

        $resetToken = $request->reset_token;

        try {
            // ユーザー情報取得
            $passwordReset = $this->userRepository->getUserTokenFromUser($resetToken);
        } catch (Exception $e) {
            return redirect()->route('reset.form')
                ->with('flash_message', __('パスワード再設定メールに添付されたURLから遷移してください。'));
        }
        $userMail = $passwordReset->email ?? '';
        return view('auth.pwd_form',compact('passwordReset','userMail'));
    }
    // パスワード更新
    public function updatePassword(ResetPasswordRequest $request)
    {
        try {
            // ユーザー情報取得
            $passwordReset = $this->userRepository->getUserTokenFromUser($request->reset_token);
            // パスワード暗号化
            $password = Hash::make($request->password);
            // email からユーザーを取得
            $user = $this->userRepository->findFromMail($passwordReset->email);
            //パスワードを更新
            $this->userRepository->updateUserPassword($password, $user->id);
        } catch (Exception $e) {
            return redirect()->route('reset.form')
                ->with('flash_message', __('処理に失敗しました。時間をおいて再度お試しください。'));
        }

        return view('auth.pwd_comp');
    }
}
