<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('coin', function ($user) {
    return true;
}, ['guards' => ['web']]);
