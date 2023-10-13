<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Deck $deck)
    {
        $cards = $deck->cards()->whereHas('deck', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return response()->json($cards);
    }

    public function store(Request $request, Deck $deck)
    {
        $data = $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
            'image_path' => 'nullable|string',
        ]);

        $card = new Card($data);
        $deck->cards()->save($card);

        return response()->json($card, 201);
    }

    public function show(Card $card)
    {
        return response()->json($card);
    }

    public function update(Request $request, Card $card)
    {
        $data = $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
            'image_path' => 'nullable|string',
        ]);

        $card->update($data);
        return response()->json($card);
    }

    public function destroy(Card $card)
    {
        $card->delete();
        return response()->json(['message' => 'Card deleted successfully'], 200);
    }

    public function getDueCards(Deck $deck)
    {
        $dueCards = $deck->cards()->where('next_review_date', '<=', now())->get();
        return response()->json($dueCards);
    }

// Update a card's review data based on user feedback
    public function reviewCard(Request $request, $id)
    {
        $card = Card::findOrFail($id);

        if ($request->input('result') === 'right') {
            $card->review_level += 1;
        } else if ($request->input('result') === 'wrong') {
            $card->review_level = max(1, $card->review_level - 1); // Ensure it doesn't go below 1
        }

        $card->last_reviewed_date = now();
        $card->next_review_date = now()->addDays($this->getInterval($card->review_level));

        $card->save();

        return response()->json($card);
    }

// Utility function to get the next review interval based on the review level
    private function getInterval($level)
    {
        switch ($level) {
            case 1:
                return 1;
            case 2:
                return 3;
            case 3:
                return 7;
            case 4:
                return 14;
            case 5:
                return 30;
            default:
                return 30 + 15 * ($level - 5); // After level 5, add 15 days for each level
        }
    }
}
