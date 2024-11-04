<?php

namespace App\Listeners;

use App\Events\OrganizerActivated;
use Illuminate\Support\Facades\Log;
use App\service\NotificationService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrganizerActivatedNotification
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    /**
     * Handle the event.
     */
    public function handle(OrganizerActivated $user): void
    {
        // Create the message based on the active status
        $message = "Your account has been " . ($user->eventOrganizer->active_organizer == 1 ? 'Activated' : 'Deactivated');
        // Log the notification message
        Log::info('Notification sent to event organizer', [
            'organizer_id' => $user->eventOrganizer->id,
            'message' => $message,
        ]);
        // Send the notification to the event organizer
        $this->notificationService->sendNotification($user->eventOrganizer->id, $message);

        
    }
}
