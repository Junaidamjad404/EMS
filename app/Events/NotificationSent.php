<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct(array $notification)
    {
     Log::info('NotificationSent event constructed:', ['notification' => $notification]);

        $this->notification = $notification;
      
    }

    public function broadcastOn(): array
    {
        Log::info('Broadcasting to user.'. $this->notification['user_id']);

        return [
            new PrivateChannel('user.' . $this->notification['user_id']),
        ];
    }

    
    public function broadcastAs()
    {
        return 'NotificationSent';
    }
}
