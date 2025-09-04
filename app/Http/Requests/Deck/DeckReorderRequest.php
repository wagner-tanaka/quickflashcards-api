<?php

namespace App\Http\Requests\Deck;

use Illuminate\Foundation\Http\FormRequest;

class DeckReorderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'deck_orders' => ['required', 'array', 'min:1'],
            'deck_orders.*.deck_id' => ['required', 'integer', 'exists:decks,id'],
            'deck_orders.*.display_order' => ['required', 'integer', 'min:0'],
        ];
    }
}
