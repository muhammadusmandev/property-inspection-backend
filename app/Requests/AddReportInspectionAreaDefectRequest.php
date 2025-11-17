<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddReportInspectionAreaDefectRequest extends FormRequest
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
            'inspection_area_id' => ['required', 'integer', 'exists:report_inspection_areas,id'],
            'defect_item_id' => ['required', 'integer', 'exists:inspection_area_items,id'],
            'defect_type' => 'required|in:cosmetic,structural,safety',
            'remediation' => 'required|in:none,cleaning,maintenance',
            'priority' => 'required|in:low,medium,high',
            'comments' => ['required', 'string', 'max:500'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'defect_type.in' => 'Defect type must be cosmetic, structural, or safety.',
            'remediation.in' => 'Remediation must be none, cleaning, or maintenance.',
            'priority.in' => 'Priority must be low, medium, or high.',
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
