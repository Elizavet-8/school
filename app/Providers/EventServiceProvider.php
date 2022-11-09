<?php

namespace App\Providers;

use App\Events\CommetCreated;
use App\Events\CommetPractical;
use App\Listeners\NewCommetNotification;
use App\Listeners\NewCommetPractical;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommetCreated::class => [
            NewCommetNotification::class,
        ],
        CommetPractical::class => [
            NewCommetPractical::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
