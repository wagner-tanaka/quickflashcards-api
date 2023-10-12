<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    public function index()
    {
        $decks = auth()->user()->decks;
        return response()->json($decks);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $deck = auth()->user()->decks()->create($data);

        return response()->json($deck, 201);
    }

    public function show(Deck $deck)
    {
        return response()->json($deck);
    }

    public function update(Request $request, Deck $deck)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $deck->update($data);

        return response()->json($deck);
    }

    public function destroy(Deck $deck): JsonResponse
    {
        $deck->delete();

        return response()->json(['message' => 'Deck deleted successfully.'], 200);
    }

}
