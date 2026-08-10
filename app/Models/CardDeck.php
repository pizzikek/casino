<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardDeck extends Model
{
    protected $casts = [
        'deck' => \App\Casts\AsDeckOfCards::class,
    ];
}
