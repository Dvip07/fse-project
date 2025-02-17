<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequirementsRequest extends FormRequest
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
            'requirementTitle' => 'required|string|max:255',
            'requirementDescription' => 'required|string|max:255',
            'requirementPriority' => 'required|integer|in:1,2,3',
            'relatedTask' => 'nullable|exists:ai_response,id',
            'user_id' => 'required|integer|exists:users,id',
            'projectId' => 'required|integer|exists:projects,id',
        ];
    }
}
