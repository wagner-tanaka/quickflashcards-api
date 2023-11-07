<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardPhrase extends Model
{
    protected $guarded = ['id'];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
