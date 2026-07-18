<?php

namespace App\Console\Commands;

use App\Events\UserLeft;
use App\Models\User;
use Illuminate\Console\Command;

class EventCommand extends Command
{
    protected $signature = 'event';

    protected $description = 'Command description';

    public function handle(): void
    {
        event(new UserLeft(User::first()));
    }
}
