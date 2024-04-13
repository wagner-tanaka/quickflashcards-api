<?php

namespace App\Http\Controllers;

use App\Http\Requests\Deck\DeckCreateRequest;
use App\Http\Requests\Deck\DeckUpdateRequest;
use App\Models\Deck;
use Illuminate\Http\JsonResponse;

class DeckController extends Controller
{
    public function index()
    {
        $decks = auth()->user()->decks;
        return response()->json($decks);
    }

    public function store(DeckCreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $deck = auth()->user()->decks()->create($data);

        return response()->json($deck, 201);
    }

    public function show(Deck $deck)
    {
        return response()->json($deck);
    }

    public function update(DeckUpdateRequest $request, Deck $deck)
    {
        $data = $request->validated();

        $deck->update($data);

        return response()->json($deck);
    }

    public function destroy(Deck $deck): JsonResponse
    {
        $deck->delete();

        return response()->json(['message' => 'Deck deleted successfully.']);
    }
}
