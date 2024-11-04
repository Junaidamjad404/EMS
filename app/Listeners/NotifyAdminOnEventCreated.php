<?php

namespace App\Listeners;

use App\Events\EventCreated;
use Illuminate\Support\Facades\Log;
use App\service\NotificationService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminOnEventCreated
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(EventCreated $event)
    {
        // Ensure you access the title correctly
        $eventTitle = $event->event->title; // Adjust this if your structure is different
        $message = "A new event has been created: {$eventTitle}";

        // Log the notification action
        Log::info("NotifyAdminOnEventCreated", [
            'event_id' => $event->event->id, // Log the ID of the event for tracking
            'title' => $eventTitle,
            'user_id' => $event->userId, // Log the user ID if necessary
        ]);

        // Send the notification using your notification service
        $this->notificationService->sendNotification($event->userId, $message);
    }
}
