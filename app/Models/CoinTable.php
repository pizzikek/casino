<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinTable extends Model
{
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_coin_table_pivot');
    }
}
