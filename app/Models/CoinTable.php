<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CoinTable extends Model
{
    public function players(): MorphMany
    {
        return $this->morphMany(User::class, 'playable');
    }
}
