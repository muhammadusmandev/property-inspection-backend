<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'gender'       => 'nullable|in:male,female,other',
            'date_of_birth'=> 'nullable|date',
            'bio'          => 'nullable|string|max:500',
            'is_active'    => 'boolean',
        ];
    }
}
