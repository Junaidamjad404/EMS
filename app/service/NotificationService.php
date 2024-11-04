<?php

namespace App\service;

use Pusher\Pusher;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected $pusher;

    public function __construct()
    {
        $options = [
            'cluster' => 'ap2',
            'useTLS' => true
        ];

        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
    }

    public function sendNotification($adminId, $message)
    {
        $notification = [
            'user_id' => $adminId,
            'message' => $message,
        ];

        Log::info('Notification triggered:', ["user.{$adminId}", "NotificationSent", $notification]);

        try {
            $this->pusher->trigger("user.{$adminId}", "NotificationSent", $notification);
        } catch (\Exception $e) {
            Log::error('Error sending notification:', ['error' => $e->getMessage()]);
        }
    }
}
