<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaveReportSignatureRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:250'
            ],
            'email' => [
                'required',
                'email',
                'max:200'
            ],
            'role' => [
                'required',
                'string',
                'in:landlord,tenant'
            ],
            'signature' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Check if starts with base64 image prefix
                    if (!preg_match('/^data:image\/(png|jpe?g);base64,/', $value)) {
                        return $fail('Invalid signature format.');
                    }

                    // Try decoding (ensures valid base64)
                    $data = substr($value, strpos($value, ',') + 1);
                    if (!base64_decode($data, true)) {
                        return $fail('Signature must be valid base64.');
                    }
                }
            ],
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
