<?php

namespace App\Http\Requests\Enterprise;

use App\Rules\CountriesInDatabase;
use App\Rules\DocumentTypesInDatabase;
use App\Rules\StatusEnterpriseInDatabase;
use App\Rules\UsersInDatabase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateEnterpriseRequest extends FormRequest
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
            "name" => ['required'],
            "document_type" => ['required', new DocumentTypesInDatabase],
            "status" => ['required', new StatusEnterpriseInDatabase],
            "email" => ['required', 'email'],
            "user_id" => ['required', new UsersInDatabase],
            "country_id" => ['required', new CountriesInDatabase],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'document_type.required' => 'Document type is required',
            'status.required' => 'Status is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email does not have a valid format',
            'user_id.required' => 'User id is required',
            'country_id.required' => 'Country id is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
