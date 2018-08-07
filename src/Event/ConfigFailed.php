<?php

namespace OkamiChen\ConfigureClient\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConfigFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    protected $time;
    
    protected $message;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($time, $message)
    {
        $this->time     = $time;
        $this->message  = $message;
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
