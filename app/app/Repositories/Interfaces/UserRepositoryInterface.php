<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\PasswordReset;

interface UserRepositoryInterface
{
    /**
     * メールアドレスからユーザー情報を取得
     *
     * @param string $mail
     * @return User
     */
    //メールアドレスからユーザー情報を取得する関数
    public function findFromMail(string $mail): User;

    /**
     * パスワードリセット用トークンを発行
     *
     * @param int $userId
     * @return PasswordReset
     */
    //PasswordResetテーブルのemailから、パスワードリセット用トークンを発行（または更新）する関数
    public function updateOrCreateUser(string $email): PasswordReset;

    /**
     * トークンからユーザー情報を取得
     * @param string $token
     * @return PasswordReset
     */
    //リセットトークンから該当ユーザーのトークン情報を取得する関数
    public function getUserTokenFromUser(string $token): PasswordReset;

    /**
     * パスワード更新
     *
     * @param string $password
     * @param int $id
     * @return void
     */
    //リセットトークンから該当ユーザーのトークン情報を取得する
    public function updateUserPassword(string $password, int $id): void;
}
