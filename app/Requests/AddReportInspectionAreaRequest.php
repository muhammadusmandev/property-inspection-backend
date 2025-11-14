<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddReportInspectionAreaRequest extends FormRequest
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
            'report_id' => ['required', 'integer', 'exists:reports,id'],
            'name' => ['required', 'string', 'max:150'],
            'condition' => [
                'required',
                'string',
                'in:excellent,good,fair,poor,Unacceptable'
            ],
            'cleanliness' => [
                'required',
                'string',
                'in:excellent,good,fair,poor,Unacceptable'
            ],
            'description' => ['required', 'string', 'max:500'],
            'items' => ['required', 'array'],
            'items.*' => ['string'],
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
