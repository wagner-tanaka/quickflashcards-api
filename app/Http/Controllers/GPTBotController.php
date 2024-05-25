<?php

namespace App\Http\Controllers;

use App\Actions\GptBot\GenerateImageAction;
use App\Actions\GptBot\GetTranslationAction;
use App\Http\Requests\GptBot\GenerateImageRequest;
use App\Http\Requests\GptBot\GetTranslationRequest;
use Illuminate\Http\JsonResponse;

class GPTBotController extends Controller
{
    public function getTranslation(GetTranslationRequest $request, GetTranslationAction $action): JsonResponse
    {
        return $action->execute($request->validated());
    }

    public function generateImage(GenerateImageRequest $request, GenerateImageAction $action): JsonResponse
    {
        return $action->execute($request->validated());
    }
}
