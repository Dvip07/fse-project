<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectsRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'domain' => 'required',
            'tech_stack' => 'required',
            'dev_methods' => 'required',
            'milestone' => 'required',
            'additional_instruction' => 'nullable|string',
            'nonFunctional' => 'nullable|string',
            'surveyMethod' => 'required',
            'stakeholderName' => 'required',
            // 'stakeholdersRole' => 'required',
        ];
    }
}
