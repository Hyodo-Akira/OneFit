<?php

namespace App\Mail;

use Illuminate\Bus\Queueable; //メールをキューに入れて送信できるようにする機能
use Illuminate\Mail\Mailable; //ララベルのメール送信用クラスの親クラス
use Illuminate\Queue\SerializesModels; //モデルをメールで使うための機能
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\URL; //一時的に有効なURLを生成するためのクラス
use Carbon\Carbon;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $passwordReset;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, PasswordReset $passwordReset)
    {
        $this->user = $user;
        $this->passwordReset = $passwordReset;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    //メールを構成する関数
    public function build()
    {
        //URLにいれるためのトークンを準備
        $tokenParam = ['reset_token' => $this->passwordReset->token];
        //現在の日時を取得
        $now = Carbon::now();
        // 署名付き有効期限24時間のURLを生成
        $url = URL::temporarySignedRoute('reset.password.edit' , $now->addHours(24), $tokenParam);

        // HTML形式でメール作成
        return $this->view('mails.pwd_reset_mail')
                    ->subject('パスワード再設定用URLのご案内')
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($this->user->email)
                    ->with([
                        'user' => $this->user,
                        'url' => $url,
                        ]);
    }
}
