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
}
