<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'sometimes|string|max:255',
            'email'        => 'sometimes|email|unique:users,email,' . $this->route('id'),
            'phone_number' => 'nullable|string|max:20',
            'gender'       => 'nullable|in:male,female,other',
            'date_of_birth'=> 'nullable|date',
            'bio'          => 'nullable|string|max:500',
            'is_active'    => 'boolean',
        ];
    }
}
