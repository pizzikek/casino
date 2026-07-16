<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinTable extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_coin_table_pivot');
    }
}
