<?php

namespace App\Actions\Cards;

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\UploadedFile;

class CreateCardAction
{
    public function handle(array $validatedData, Deck $deck): void
    {
        $card = $this->createCard($validatedData);
        $this->saveImageIfNeeded($validatedData, $card);
        $deck->cards()->save($card);
        $this->attachPhrasesIfNeeded($validatedData, $card);
        $card->load('phrases');
    }

    private function createCard(array $data): Card
    {
        return new Card([
            'front' => $data['front'],
            'back' => $data['back'],
            'pronunciation' => $data['pronunciation'] ?? null,
        ]);
    }

    private function saveImageIfNeeded(array $data, Card $card): void
    {
        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $path = $data['image']->store('cards');
            $card->image_path = $path;
        }
    }

    private function attachPhrasesIfNeeded(array $data, Card $card): void
    {
        if (!empty($data['phrases'])) {
            $phrases = json_decode($data['phrases'], true);
            if (is_array($phrases)) {
                foreach ($phrases as $phrase) {
                    if (!empty($phrase)) {
                        $card->phrases()->create(['phrase' => $phrase]);
                    }
                }
            }
        }
    }
}
