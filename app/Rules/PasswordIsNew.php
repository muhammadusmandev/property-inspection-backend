<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class PasswordIsNew implements ValidationRule
{
    protected $user;

    /**
     * Initialize user object
     * 
     * @param  \App\Models\User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (\Hash::check($value, $this->user->password)) {
            $fail(__('validationMessages.password.must_new'));
        }
    }
}
