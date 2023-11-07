<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function deck(): BelongsTo
    {
        return $this->belongsTo(Deck::class);
    }

    public function phrases(): HasMany
    {
        return $this->hasMany(CardPhrase::class);
    }
}
