<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\Request;

class CardController extends Controller
{

    public function index(Deck $deck)
    {
        if ($deck->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cards = $deck->cards()->with('phrases')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($cards);
    }

    public function store(Request $request, Deck $deck)
    {
        $data = $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
            'pronunciation' => 'nullable|string',
            'image_path' => 'nullable|string',
            'phrases' => 'array',
            'phrases.*' => 'string'
        ]);

        $card = new Card($data);
        $deck->cards()->save($card);

        if (!empty($request->phrases)) {
            foreach ($request->phrases as $phrase) {
                if ($phrase !== null && $phrase !== '') {
                    $card->phrases()->create(['phrase' => $phrase]);
                }
            }
        }

        $card->load('phrases');

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
            'pronunciation' => 'nullable|string',
            'image_path' => 'nullable|string',
            'phrases' => 'array',
        ]);

        $phrases = $request->validate([
            'phrases.*' => 'string',
        ])['phrases'] ?? [];

        $card->phrases()->delete();

        foreach ($phrases as $phraseText) {
            $card->phrases()->create(['phrase' => $phraseText]);
        }

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
        $dueCards = $deck->cards()
            ->with('phrases')
            ->where(function ($query) {
                $query->where('next_review_date', '<=', now())
                    ->orWhereNull('next_review_date');
            })->get();

        return response()->json($dueCards);
    }

    public function reviewCard(Request $request, $id)
    {
        $card = Card::findOrFail($id);

        if ($request->input('result') === 'right') {
            $card->review_level += 1;
        } else if ($request->input('result') === 'wrong') {
            $card->review_level = 0;
        }

        $card->last_reviewed_date = now();
        $card->next_review_date = now()->addDays($this->getInterval($card->review_level));

        if ($card->review_level >= 8) { // Level 8 means no more reviews
            $card->is_active = false;
        }

        $card->save();

        return response()->json($card);
    }

    private function getInterval($level)
    {
        switch ($level) {
            case 0:
                return 0;
            case 1:
                return 1; // 1 day
            case 2:
                return 3; // 3 days
            case 3:
                return 7; // 7 days
            case 4:
                return 14; // 2 weeks
            case 5:
                return 30; // 1 month
            case 6:
                return 90; // 3 months
            case 7:
                return 180; // 6 months
            default:
                // Level 8 and above (don't review anymore)
                return 9999; // A large number to simulate "forever"
        }
    }
}
