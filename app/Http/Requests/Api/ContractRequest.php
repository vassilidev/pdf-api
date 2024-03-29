<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'author'  => [
                'required',
                'string',
            ],
            'content' => [
                'string',
                'nullable',
            ],
            'name'    => [
                'string',
                'required',
            ],
            'data' => [
                'sometimes',
                'nullable',
                'array',
            ],
        ];
    }
}
