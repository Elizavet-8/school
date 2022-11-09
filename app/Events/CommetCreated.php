<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommetCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * @var Theme
     */
    public $theme_id;

    /**
     * @var array
     */
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $theme_id)
    {
        $this->theme_id = $theme_id;
    }
}
