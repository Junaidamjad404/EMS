<?php

namespace App\Providers;

use App\Events\EventCreated;
use App\Events\EventApproved;
use App\Events\OrganizerActivated;
use Illuminate\Support\Facades\Event;
use App\Listeners\NotifyAdminOnEventCreated;
use App\Listeners\NotifyOrganizerOnEventApproved;
use App\Listeners\SendOrganizerActivatedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        EventCreated::class => [
            NotifyAdminOnEventCreated::class,
        ],
        EventApproved::class => [
            NotifyOrganizerOnEventApproved::class,
        ],
        OrganizerActivated::class => [
            SendOrganizerActivatedNotification::class
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
