<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateReportRequest extends FormRequest
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
            'title' => 'required|string',
            'notes' => 'nullable|string',
            'property_id' => 'required|integer|exists:properties,id',
            'template_id' => 'required|integer|exists:templates,id',
            'type' => 'required|in:check-in,check-out,inventory,inspection',
            'report_date' => 'required|date',
            'areas' => 'nullable|array',
            'areas.*.id' => 'nullable|exists:report_inspection_areas,id',
            'areas.*.name' => 'required|string',
            'areas.*.condition' => 'required|in:excelent,good,fair,poor,unacceptable',
            'areas.*.cleanliness' => 'required|in:excelent,good,fair,poor,unacceptable',
            'areas.*.description' => 'nullable|string',

            'areas.*.items' => 'nullable|array',
            'areas.*.items.*.name' => 'nullable|string',
            'areas.*.items.*.condition' => 'required_with:areas.*.items.*.name|nullable|in:excelent,good,fair,poor,unacceptable',
            'areas.*.items.*.cleanliness' => 'required_with:areas.*.items.*.name|nullable|in:excelent,good,fair,poor,unacceptable',
            'areas.*.items.*.description' => 'nullable|string',

            'areas.*.areaDefects' => 'nullable|array',
            'areas.*.areaDefects.*.id' => 'nullable|exists:report_defects,id',
            'areas.*.areaDefects.*.category' => 'required|in:none,cleaning,maintenance',
            'areas.*.areaDefects.*.description' => 'nullable|string',
        ];
    }

      /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return void
     */
    protected function failedValidation(Validator  $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
