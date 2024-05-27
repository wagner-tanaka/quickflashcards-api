<?php

namespace App\Actions\Cards;

use App\Models\Card;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class GetCardImageAction
{
    public function handle(Card $card): BinaryFileResponse
    {
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
