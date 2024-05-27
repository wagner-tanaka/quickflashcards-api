<?php

namespace App\Actions\Deck;

use App\Models\Deck;
use Illuminate\Support\Collection;

class GetDeckCardsAction
{
    public function handle(Deck $deck): Collection
    {
        return $deck->cards()->with('phrases')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($card) {
                if ($card->image_path) {
                    $image_url = route('cards.get-image', ['card' => $card->id]);
                    $card->image_url = $image_url;
                }
                return $card;
            });
    }
}
