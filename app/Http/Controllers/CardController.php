<?php

namespace App\Http\Controllers;

use App\Actions\Cards\CreateCardAction;
use App\Actions\Cards\GetCardImageAction;
use App\Actions\Cards\ReviewCardAction;
use App\Actions\Cards\UpdateCardAction;
use App\Actions\Deck\GetCardsToStudyAction;
use App\Actions\Deck\GetDeckCardsAction;
use App\Http\Requests\Cards\CardCreateRequest;
use App\Http\Requests\Cards\CardReviewRequest;
use App\Http\Requests\Cards\CardUpdateRequest;
use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CardController extends Controller
{

    public function index(Deck $deck, GetDeckCardsAction $getDeckCardsAction): JsonResponse
    {
        if ($deck->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cards = $getDeckCardsAction->handle($deck);

        return response()->json($cards);
    }


    public function store(CardCreateRequest $request, Deck $deck, CreateCardAction $createCardAction, GetDeckCardsAction $getDeckCardsAction): JsonResponse
    {
        $createCardAction->handle($request->validated(), $deck);
        $cards = $getDeckCardsAction->handle($deck);

        return response()->json($cards, ResponseAlias::HTTP_CREATED);
    }

    public function show(Card $card)
    {
        return response()->json($card);
    }

    public function update(CardUpdateRequest $request, Card $card, UpdateCardAction $updateCardAction, GetDeckCardsAction $getDeckCardsAction): JsonResponse
    {
        $updateCardAction->handle($request->validated(), $card);
        $cards = $getDeckCardsAction->handle($card->deck);

        return response()->json($cards);
    }

    public function destroy(Card $card): JsonResponse
    {
        $card->delete();
        return response()->json(['message' => 'Card deleted successfully'], 200);
    }

    public function reviewCard(CardReviewRequest $request, Card $card, ReviewCardAction $reviewCardAction): JsonResponse
    {
        $card = $reviewCardAction->handle($request->validated(), $card);

        return response()->json($card);
    }

    public function getCardsToStudy(Deck $deck, GetCardsToStudyAction $action): JsonResponse
    {
        $cardsToStudy = $action->handle($deck);

        return response()->json($cardsToStudy);
    }

    public function getCardImage(Card $card, GetCardImageAction $action): BinaryFileResponse
    {
        return $action->handle($card);
    }

}
