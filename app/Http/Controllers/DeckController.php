<?php

namespace App\Http\Controllers;

use App\Actions\Deck\ReorderDecksAction;
use App\Http\Requests\Deck\DeckCreateRequest;
use App\Http\Requests\Deck\DeckReorderRequest;
use App\Http\Requests\Deck\DeckUpdateRequest;
use App\Models\Deck;
use Illuminate\Http\JsonResponse;

class DeckController extends Controller
{
    public function index(): JsonResponse
    {
        $decks = auth()->user()->decks()
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($decks);
    }

    public function store(DeckCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set display_order to be the maximum existing order + 1 for this user
        $maxOrder = auth()->user()->decks()->max('display_order') ?? -1;
        $data['display_order'] = $maxOrder + 1;

        $deck = auth()->user()->decks()->create($data);

        return response()->json($deck, 201);
    }

    public function show(Deck $deck): JsonResponse
    {
        return response()->json($deck);
    }

    public function update(DeckUpdateRequest $request, Deck $deck): JsonResponse
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

    public function reorder(DeckReorderRequest $request, ReorderDecksAction $action): JsonResponse
    {
        $data = $request->validated();
        
        $decks = $action->execute($data['deck_orders'], auth()->id());
        
        return response()->json([
            'message' => 'Decks reordered successfully.',
            'decks' => $decks
        ]);
    }
}
