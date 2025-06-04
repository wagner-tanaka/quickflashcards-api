<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = ['id'];

    public function decks(): HasMany
    {
        return $this->hasMany(Deck::class);
    }

    public function sumTest(int $a, int $b): string
    {
        return $a + $b;
    }

    public function sumTest1(int $a, int $b): string
    {
        return $a + $b;
    }

    public function sumTest2(int $a, int $b): string
    {
        return $a + $b;
    }

    public function sumTest3(int $a, int $b): string
    {
        return $a + $b;
    }

    public function sumTest4(int $a, int $b): string
    {
        return $a + $b;
    }

    public function func2(int $a, int $b): string
    {
        return $a + $b;
    }

    public function sumTest5(int $a, int $b): string
    {
        return $a + $b;
    }

    public function func1(string $a): int
    {
        return $a . 'foo';
    }

    public function func3(string $a): int
    {
        return $a . 'foo';
    }

    public function func4(string $a): int
    {
        return $a . 'foo';
    }
}
