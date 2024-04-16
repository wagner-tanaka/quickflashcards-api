<?php

namespace App\Http\Requests\Cards;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CardStoreRequest extends FormRequest
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
            'front' => 'required|string',
            'back' => 'required|string',
            'pronunciation' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'phrases' => 'nullable|string',
            'phrases.*' => 'string'
        ];
    }
}
