<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\PasswordIsNew;
use App\Models\User;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required', 
                'email',
                'max:200',
                'exists:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:60',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).+$/',   // must one one lowercase letter, one uppercase letter, one digit, one special character (@$!%*?&#)
                new PasswordIsNew($this->getResetUser()),
            ],
            'otp_session_token' => [
                'required', 
                'uuid'
            ]
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.exists' => __('validationMessages.email.exists'),
            'password.regex' => __('validationMessages.password.regex'),
            'password.min' => __('validationMessages.password.min', ['character' => 8]),
            'password.max' => __('validationMessages.password.max', ['character' => 60]),
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Oops! Validation Failed.',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    protected function getResetUser(): ?User
    {
        return User::where('email', $this->input('email'))->firstOrFail();
    }
}
