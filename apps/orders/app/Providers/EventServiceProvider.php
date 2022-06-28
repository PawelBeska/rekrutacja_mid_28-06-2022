<?php

namespace App\Providers;

use App\Events\OrderChangedStatusEvent;
use App\Listeners\OrderChangedStatusListener;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderChangedStatusEvent::class => [
            OrderChangedStatusListener::class,
        ],

    ];


    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Order::class => [OrderObserver::class],
    ];
}
