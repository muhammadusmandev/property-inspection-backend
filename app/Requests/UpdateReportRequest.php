<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'report_id' => 'required|integer|exists:reports,id',
            'title' => 'required|string',
            'notes' => 'nullable|string',
            'property_id' => 'required|integer|exists:properties,id',
            'template_id' => 'requiredinteger|exists:templates,id',
            'type' => 'required|in:check-in,check-out,inventory,inspection',

            'inspection_areas' => 'nullable|array',
            'inspection_areas.*.id' => 'nullable|exists:report_inspection_areas,id',
            'inspection_areas.*.name' => 'required|string',
            'inspection_areas.*.condition' => 'required|in:excelent,good,fair,poor,Unacceptable',
            'inspection_areas.*.cleanliness' => 'required|in:excelent,good,fair,poor,Unacceptable',
            'inspection_areas.*.description' => 'nullable|string',

            'inspection_areas.*.items' => 'nullable|array',
            'inspection_areas.*.items.*.name' => 'nullable|string',
            'inspection_areas.*.items.*.condition' => 'required_with:inspection_areas.*.items.*.name|nullable|in:excelent,good,fair,poor,Unacceptable',
            'inspection_areas.*.items.*.cleanliness' => 'required_with:inspection_areas.*.items.*.name|nullable|in:excelent,good,fair,poor,Unacceptable',
            'inspection_areas.*.items.*.description' => 'nullable|string',

            'inspection_areas.*.defects' => 'nullable|array',
            'inspection_areas.*.defects.*.id' => 'nullable|exists:report_defects,id',
            'inspection_areas.*.defects.*.category' => 'required|in:none,cleaning,maintenance',
            'inspection_areas.*.defects.*.description' => 'nullable|string',
        ];
    }
}
