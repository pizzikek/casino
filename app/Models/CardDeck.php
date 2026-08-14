<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CardDeck extends Model
{
    protected $casts = [
        'deck' => \App\Casts\AsDeckOfCards::class,
    ];

    public function deckable(): MorphTo
    {
        return $this->MorphTo();
    }
}
