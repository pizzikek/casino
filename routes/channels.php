<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('coin', function ($user) {
    return true;
}, ['guards' => ['web']]);
Broadcast::channel('baccarat', function ($user) {
    return true;
}, ['guards' => ['web']]);
