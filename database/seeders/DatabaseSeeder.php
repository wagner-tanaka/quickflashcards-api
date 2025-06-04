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
            'last_name' => 'test',
            'email' => 'test@mail.com',
            'password' => Hash::make('P@ssw0rd'),
        ]);

        // Create an array of English words and their corresponding translations
        $wordPairs = [
            'Flyers' => 'Folhetos',
            'fence' => 'cerca',
            'weren\'t' => 'nao estavam',
            'held' => 'Feito/mantido',
            'of the' => 'pela',
            'box office' => 'renda de bilheteira',
            'advertisement' => 'anúncio',
            'striped' => 'listrado',
            'extension cords' => 'cabos de extensão',
            'drawer' => 'gaveta',
            'up ahead.' => 'à Frente.',
            'Skimming' => 'Leitura rápida',
            'unfortunately' => 'Infelizmente',
            'venue' => 'local',
            'trouser' => 'calça',
            'to sweep' => 'varrer',
            'to lean' => 'inclinar',
            'lid' => 'tampa',
            'stool' => 'banco',
            'brick' => 'tijolo',
            'to sew' => 'costurar',
            'to scatter' => 'espalhar',
            'to stack' => 'empilhar',
            'railing' => 'corrimão',
            'to mow' => 'cortar',
            'lawn' => 'grama',
            'grocery' => 'mercearia',
            'rafting' => 'andar de barco',
            'fabric' => 'tecido',
            'enhance' => 'melhorar',
            'freight' => 'frete',
            'publicize' => 'divulgar',
            'tuition' => 'conta',
            'compliance' => 'conformidade',
            'preply' => 'prépli',
            'half' => 'metade',
            'real estate agent' => 'corretor de imoveis',
            'real estate' => 'imobiliaria',
            'accountant' => 'Contador',
            'reassure' => 'Tranquilizar',
            'shifts' => 'turno',
            'landscaping' => 'Paisagismo',
            'clerks' => 'funcionário',
            'to assembly' => 'montar',
            'leverage' => 'aproveitar',
        ];


        // Get the deck with deck_id 1
        $deck = Deck::create([
            'user_id' => $user->id,
            'name' => 'Deck 1',
            'description' => 'English to Portuguese Translation',
        ]);

        // Seeding cards for deck 1
        foreach ($wordPairs as $englishWord => $translation) {
            Card::create([
                'deck_id' => $deck->id,
                'front' => $englishWord,
                'back' => $translation,
                'rarity' => 'common',
                'usage' => 'normal',
                'review_level' => rand(1, 5),
                'last_reviewed_date' => now(),
                'next_review_date' => now()->addDays(rand(1, 5)),
            ]);
        }
    }
}
