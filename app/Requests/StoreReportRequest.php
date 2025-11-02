<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'title' => 'required|string',
            'notes' => 'nullable|string',
            'property_id' => 'required|integer|exists:properties,id',
            'template_id' => 'requiredinteger|exists:templates,id',
            'type' => 'required|in:check-in,check-out,inventory,inspection',
        ];
    }
}
