<?php
namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportContactUpdateRequest  extends FormRequest
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
            'name'          => 'sometimes|string|max:200',
            'email'         => 'nullable|email|max:200',
            'phone'         => 'nullable|string|max:50',
            'contact_type'  => 'sometimes|string|in:landlord,tenant,co_tenant,owner,occupant,property_manager,letting_agent,estate_agent,contractor,inspector,witness,legal_representative,insurance_assessor,company_representative,emergency_contact,other',
            'can_sign'      => 'sometimes|boolean',
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
