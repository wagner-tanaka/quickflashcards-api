<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeckControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_decks_are_sorted_by_latest_first(): void
    {
        $user = User::factory()->create();

        $oldDeck = $user->decks()->create([
            'name' => 'Old Deck',
            'description' => 'First',
        ]);
        // Ensure the old deck has an earlier creation date
        $oldDeck->update(['created_at' => now()->subMinute()]);

        $newDeck = $user->decks()->create([
            'name' => 'New Deck',
            'description' => 'Second',
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/decks');

        $response->assertStatus(200);

        $resultIds = array_column($response->json(), 'id');
        $this->assertSame([$newDeck->id, $oldDeck->id], $resultIds);
    }
}
