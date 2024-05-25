<?php

namespace App\Actions\GptBot;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class GenerateImageAction
{
    public function execute(array $validatedData): JsonResponse
    {
        $imageReferenceWord = $validatedData['imageReferenceWord'];

        try {
            $response = $this->sendImageGenerateRequest($imageReferenceWord);
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    private function sendImageGenerateRequest(string $word): Response
    {
        $AIBotPath = config('services.ai_bot.path');
        return Http::post($AIBotPath . '/generate-image', [
            'image_reference_word' => $word,
        ]);
    }

    private function handleResponse($response): JsonResponse
    {
        $responseBody = $response->json();

        if ($response->successful()) {
            return response()->json($responseBody, 200);
        } else {
            return response()->json(['message' => $responseBody['detail'] ?? 'An error occurred'], $response->status());
        }
    }

    private function handleException(\Exception $e): JsonResponse
    {
        return response()->json(['message' => 'Failed to connect to translation service'], 500);
    }
}
