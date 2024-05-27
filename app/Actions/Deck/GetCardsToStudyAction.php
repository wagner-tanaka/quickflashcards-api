<?php

namespace App\Actions\Deck;

use App\Models\Deck;
use Illuminate\Support\Collection;

class GetCardsToStudyAction
{
    public function handle(Deck $deck): Collection
    {
        return $deck->cards()
            ->with('phrases')
            ->where(function ($query) {
                $query->where('next_review_date', '<=', now())
                    ->orWhereNull('next_review_date');})
            ->get()
            ->map(function ($card) {
                if ($card->image_path) {
                    $card->image_url = route('cards.get-image', ['card' => $card->id]);
                }
                return $card;
            });
    }
}
