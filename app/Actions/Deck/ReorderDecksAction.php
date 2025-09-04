<?php

namespace App\Actions\Deck;

use App\Models\Deck;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReorderDecksAction
{
    public function execute(array $deckOrders, int $userId): array
    {
        // Validate that all deck IDs belong to the authenticated user
        $deckIds = collect($deckOrders)->pluck('deck_id');
        $userDecks = Deck::where('user_id', $userId)->whereIn('id', $deckIds)->get();
        
        if ($userDecks->count() !== $deckIds->count()) {
            throw ValidationException::withMessages([
                'deck_orders' => ['One or more deck IDs do not belong to the authenticated user.']
            ]);
        }

        // Update display_order values in a single transaction
        DB::transaction(function () use ($deckOrders, $userId) {
            foreach ($deckOrders as $order) {
                Deck::where('id', $order['deck_id'])
                    ->where('user_id', $userId)
                    ->update(['display_order' => $order['display_order']]);
            }
        });

        // Return updated deck list ordered by display_order
        return Deck::where('user_id', $userId)
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }
}