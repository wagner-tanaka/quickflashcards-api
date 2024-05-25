<?php

namespace App\Http\Controllers;

use App\Actions\Cards\CreateCardAction;
use App\Actions\Cards\UpdateCardAction;
use App\Http\Requests\Cards\CardCreateRequest;
use App\Http\Requests\Cards\CardUpdateRequest;
use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CardController extends Controller
{

    public function index(Deck $deck): JsonResponse
    {
        if ($deck->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cards = $this->getDeckCards($deck);

        return response()->json($cards);
    }


    public function store(CardCreateRequest $request, Deck $deck, CreateCardAction $createCardAction): JsonResponse
    {
        $createCardAction->execute($request->validated(), $deck);
        $cards = $this->getDeckCards($deck);

        return response()->json($cards, ResponseAlias::HTTP_CREATED);
    }

    public function show(Card $card)
    {
        return response()->json($card);
    }

    public function update(CardUpdateRequest $request, Card $card, UpdateCardAction $updateCardAction): JsonResponse
    {
        $updateCardAction->execute($request->validated(), $card);
        $cards = $this->getDeckCards($card->deck);

        return response()->json($cards);
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
                    ->orWhereNull('next_review_date');})
            ->get()
            ->map(function ($card) {
                if ($card->image_path) {
                    $card->image_url = route('cards.get-image', ['card' => $card->id]);
                }
                return $card;
            });

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

    public function getDeckCards(Deck $deck): Collection
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

    public function getImage($cardId): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $card = Card::findOrFail($cardId);
        $path = storage_path('app/' . $card->image_path);

        if (!File::exists($path)) {
            abort(404, 'Image not found.');
        }

        $type = File::mimeType($path);

        return response()->file($path, [
            'Content-Type' => $type
        ]);
    }

}
