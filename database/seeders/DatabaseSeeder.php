<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Deck;
use App\Models\Card;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seeding the user
        $user = User::create([
            'first_name' => 'test',
            'last_name'  => 'test',
            'email'      => 'test@mail.com',
            'password'   => Hash::make('P@ssw0rd'),
        ]);

        // Seeding 5 decks for the user
        for ($i = 1; $i <= 5; $i++) {
            $deck = Deck::create([
                'user_id'     => $user->id,
                'name'        => 'Deck ' . $i,
                'description' => 'Description for Deck ' . $i,
            ]);

            // Seeding 5 cards for each deck
            for ($j = 1; $j <= 5; $j++) {
                Card::create([
                    'deck_id'           => $deck->id,
                    'front'             => 'Front side of Card ' . $j . ' in Deck ' . $i,
                    'back'              => 'Back side of Card ' . $j . ' in Deck ' . $i,
                    'review_level'      => rand(1, 5), // assuming you might want different review levels. You can adjust this.
                    'last_reviewed_date'=> now(),
                    'next_review_date'  => now()->addDays(rand(1, 5)), // just for varied data
                ]);
            }
        }
    }
}
