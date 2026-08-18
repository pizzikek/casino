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
    private int $id;
    private string $channel;
    public function __construct(public mixed $playerList, private int $id_param, private string $channel_param, public mixed $data = null)
    {
        $this->id = $id_param;
        $this->channel = $channel_param;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel($this->channel),
        ];
    }

    public function broadcastAs(): string
    {
        return 'player-list-changed'. $this->id;
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
            'data' => $this->data,

        ];
    }
}
