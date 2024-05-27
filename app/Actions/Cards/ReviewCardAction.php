<?php

namespace App\Actions\Cards;

use App\Enums\ReviewInterval;
use App\Models\Card;

class ReviewCardAction
{
    public function handle(array $data, Card $card): Card
    {
        $this->updateReviewLevel($data['result'], $card);
        $this->updateReviewDates($card);
        $this->checkAndDeactivateCard($card);

        $card->save();

        return $card;
    }

    private function updateReviewLevel(string $result, Card $card): void
    {
        if ($result === 'right') {
            $card->review_level += 1;
        } elseif ($result === 'wrong') {
            $card->review_level = 0;
        }
    }

    private function updateReviewDates(Card $card): void
    {
        $card->last_reviewed_date = now();
        $card->next_review_date = now()->addDays($this->getInterval($card->review_level));
    }

    private function checkAndDeactivateCard(Card $card): void
    {
        if ($card->review_level >= 8) {
            $card->is_active = false;
        }
    }

    private function getInterval(int $reviewLevel): int
    {
        return ReviewInterval::tryFrom($reviewLevel)?->getInterval() ?? 9999;
    }
}
