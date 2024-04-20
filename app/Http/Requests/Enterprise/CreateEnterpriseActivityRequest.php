<?php

namespace App\Http\Requests\Enterprise;

use App\Rules\ActivitiesInDatabase;
use App\Rules\EnterprisesInDatabase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateEnterpriseActivityRequest extends FormRequest
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
            "enterprise_id" => ['required', new EnterprisesInDatabase],
            "activity_id" => ['required', new ActivitiesInDatabase],
        ];
    }

    public function messages(): array
    {
        return [
            'enterprise_id.required' => 'Enterprise ID is required',
            'activity_id.required' => 'Activity ID type is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
