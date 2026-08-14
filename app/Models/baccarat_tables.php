<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class BaccaratTable extends Model
{
    public function players(): MorphMany
    {
        return $this->morphMany(User::class, 'playable');
    }
    
    public function deck(): MorphOne
    {
        return $this->morphOne(CardDeck::class, 'deckable');
    }
}
