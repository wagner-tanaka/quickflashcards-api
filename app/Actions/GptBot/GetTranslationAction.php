<?php

namespace App\Actions\GptBot;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class GetTranslationAction
{
    public function execute(array $validatedData): JsonResponse
    {
        $word = $validatedData['wordToTranslate'];
        $model = $validatedData['gptModel'];

        try {
            $response = $this->sendTranslationRequest($word, $model);
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    private function sendTranslationRequest(string $word, string $model): Response
    {
        return Http::post('http://192.168.0.14:8000/translate', [
            'word' => $word,
            'model' => $model,
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
