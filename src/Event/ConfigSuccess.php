<?php

namespace OkamiChen\ConfigureClient\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConfigSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    protected $time;
    
    protected $config;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($time, $config)
    {
        $this->time     = $time;
        $this->config   = $config;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
