<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Models\PasswordReset;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

//UserRepositoryInterfaceの実装
class UserRepository implements UserRepositoryInterface
{
    private $user;
    private $passwordReset;

    /**
     * constructor
     *
     * @param User $user
     */
    public function __construct(User $user, PasswordReset $passwordReset)
    {
        $this->user = $user;
        $this->passwordReset = $passwordReset;
    }

    // メールアドレスからユーザー情報を取得する関数
    public function findFromMail(string $mail): User
    {
        //
        return $this->user->where('email', $mail)->firstOrFail();
    }

    //PasswordResetでパスワードリセット用トークンを発行
    public function updateOrCreateUser(string $email): PasswordReset
    {
        $this->passwordReset->updateOrCreate(
            ['email' => $email],
            [
                'token' => hash('sha256',Str::random(60)),
                'created_at' => Carbon::now(),
            ]
        );

        return $this->passwordReset->where('email',$email)->firstOrFail();
    }

    // トークンからユーザー情報を取得
    public function getUserTokenFromUser(string $token): PasswordReset
    {
        return $this->passwordReset->where('token', $token)->firstOrFail();
    }

    // パスワード更新
    public function updateUserPassword(string $password, int $id): void
    {
        $this->user->where('id', $id)->update(['password' => $password]);
    }
}
