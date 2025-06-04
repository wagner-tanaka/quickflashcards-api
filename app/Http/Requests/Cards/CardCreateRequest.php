<?php

namespace App\Http\Requests\Cards;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CardCreateRequest extends FormRequest
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
            'front' => 'required|string|max:255',
            'back' => 'required|string',
            'pronunciation' => 'nullable|string',
            'rarity' => 'nullable|string|in:common,uncommon,rare',
            'usage' => 'nullable|string|in:normal,formal,written',
            'image' => 'nullable|image|max:2048',
            'phrases' => 'nullable|string',
            'phrases.*' => 'string'
        ];
    }
}
