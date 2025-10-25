<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id'   => 'nullable|exists:branches,id',
            'client_id'   => 'nullable|exists:users,id',
            'name'        => 'sometimes|required|string|max:255',
            'address'     => 'nullable|string',
            'address_2'     => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'state'       => 'nullable|string|max:100',
            'country'     => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'type'        => 'sometimes|in:residential,commercial',
            'active'      => 'boolean',
            'reference'   => 'nullable|string|max:100',
            'notes'   => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'branch_id.exists' => __('validationMessages.branch.exists'),
            'client_id.exists' => __('validationMessages.client.exists'),
            'type.in'          => __('validationMessages.property.type_invalid'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Oops! Validation failed.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
