<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrganizerActivated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventOrganizer;

    public function __construct(User $eventOrganizer)
    {
        $this->eventOrganizer = $eventOrganizer;
         // Log the creation or loading of the event organizer
        Log::info('Organizer service initialized', [
            'organizer_id' => $this->eventOrganizer->id,
            'name' => $this->eventOrganizer->name,
            'email' => $this->eventOrganizer->email,
            'status' => $this->eventOrganizer->active_organizer ? 'Activated' : 'Deactivated',
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('organizer.' . $this->eventOrganizer->id);
    }
    public function broadcastAs()
    {
        return 'NotificationSent';
    }
}
