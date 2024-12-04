<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rideData;

    public function __construct($rideData)
    {
        $this->rideData = $rideData;
    }

    public function broadcastOn()
    {
        return new Channel('ride-channel');  // Make sure it's public or private as per your use case
    }

    public function broadcastAs()
    {
        return 'ride.created';
    }
}
