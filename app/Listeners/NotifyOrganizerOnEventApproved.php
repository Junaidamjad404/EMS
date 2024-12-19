<?php

namespace App\Listeners;

use App\Events\EventApproved;
use Illuminate\Support\Facades\Log;
use App\service\NotificationService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyOrganizerOnEventApproved
{
     protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(EventApproved $event)
    {
        Log::info("Event Organizer id: ".$event->event->organizer_id);
        Log::info("Your event has been approved: ".$event->event->title);
        $message = "Your event has been {$event->event->status}: {$event->event->title}";

        $this->notificationService->sendNotification($event->event->organizer_id, $message);
    }
}
