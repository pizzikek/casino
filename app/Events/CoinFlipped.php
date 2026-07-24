<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CoinFlipped implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public $face, public $playerList)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('coin'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'coin-flipped';
    }

    public function broadcastWith(): array
    {
        return [
            'face' => $this->face,
            'playerList' => $this->playerList->values()->map(fn ($u) => [
                'id' => $u->id,
                'username' => $u->username,
                'points_curr_table' => $u->points_curr_table,
                'curr_bet' => $u->curr_bet,
            ])->all(),
        ];
    }
}
