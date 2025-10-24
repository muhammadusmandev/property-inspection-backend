<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;

class RegisterRequest extends FormRequest
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
            'first_name' => [
                'required',
                'string',
                'max:100'
            ],
            'last_name' => [
                'required',
                'string',
                'max:100'
            ],
            'email' => [
                'required',
                'email',
                'email:rfc,dns',
                'max:200',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:60',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).+$/'   // must one one lowercase letter, one uppercase letter, one digit, one special character (@$!%*?&#)
            ],
            'phone_number' => [
                'nullable',
                'string',
                'max:20',
                'phone:AUTO'
            ],
            'profile_photo' => [
                'nullable',
                'string',
                'max:255'
            ],
            'gender' => [
                'required',
                'in:male,female,other'
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:' . Carbon::now()->subYears(15)->format('Y')
            ],
            'role' => [
                'nullable',
                'string',
                'in:realtor'
            ],

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
            'email.unique' => __('validationMessages.email.unique'),
            'phone_number.phone' => __('validationMessages.phone_number.phone'),
            'password.regex' => __('validationMessages.password.regex'),
            'gender.in' => __('validationMessages.gender.in'),
            'date_of_birth.before' => __('validationMessages.date_of_birth.before' , ['date' => Carbon::now()->subYears(10)->format('Y')]),
            'role.in' => __('validationMessages.role.in'),
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
}
