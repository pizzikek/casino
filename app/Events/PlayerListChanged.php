<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerListChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public $playerList)
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
        return 'player-list-changed';
    }

    public function broadcastWith(): array
    {
        return [
            'playerList' => $this->playerList->values()->map(fn ($u) => [
                'id' => $u->id,
                'username' => $u->username,
                'points_curr_table' => $u->points_curr_table,
                'curr_bet' => $u->curr_bet,
                'action_table' => $u->action_table,
            ])->all(),
        ];
    }
}
