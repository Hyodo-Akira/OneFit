<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\PasswordReset;
use Carbon\Carbon;

class TokenExpirationTimeCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $record = PasswordReset::where('token', $value)->first();

        if (!$record) return false;

        $expiration = Carbon::parse($record->created_at)->addHours(24);

        return Carbon::now()->lessThan($expiration);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'パスワード再設定用URLの有効期限が切れています。再度メールを送信してください。';
    }
}
