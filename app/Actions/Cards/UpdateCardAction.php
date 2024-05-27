<?php

namespace App\Actions\Cards;

use App\Models\Card;
use Illuminate\Support\Facades\Storage;

class UpdateCardAction
{
    public function handle(array $data, Card $card): void
    {
        $this->handleImageDeletionAndUpdate($data, $card);
        $this->updatePhrases($data['phrases'], $card);
        $this->updateCardFields($data, $card);
    }

    protected function handleImageDeletionAndUpdate(array $data, Card $card): void
    {
        if ($this->shouldDeleteImage($data, $card)) {
            $this->deleteExistingImage($card);
        }

        if (isset($data['image'])) {
            $this->storeNewImage($data['image'], $card);
        }
    }

    protected function shouldDeleteImage(array $data, Card $card): bool
    {
        return !isset($data['image_path']) || isset($data['image']);
    }

    protected function deleteExistingImage(Card $card): void
    {
        if ($card->image_path && Storage::disk('public')->exists($card->image_path)) {
            Storage::disk('public')->delete($card->image_path);
            $card->image_path = null;
        }
    }

    protected function storeNewImage($image, Card $card): void
    {
        $path = $image->store('cards', 'public');
        $card->image_path = $path;
    }

    protected function updatePhrases($phrasesJson, Card $card): void
    {
        $card->phrases()->delete();
        $phrases = json_decode($phrasesJson, true);

        foreach ($phrases as $phraseText) {
            $card->phrases()->create(['phrase' => $phraseText]);
        }
    }

    protected function updateCardFields(array $data, Card $card): void
    {
        $cardData = [
            'front' => $data['front'],
            'back' => $data['back'],
            'pronunciation' => $data['pronunciation'] ?? null,
        ];
        $card->update($cardData);
    }
}
