<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use App\Listeners\ProcessPaymentsOnLogin;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */

    //  protected $listen = [
    //     Login::class => [
    //         ProcessPaymentsOnLogin::class,
    //     ],
    // ];
    //     // ... other event listeners

    protected $listen = [
       
    ];

    // protected $listen = [
    //     'Illuminate\Auth\Events\Login' => [
    //         'App\Listeners\UpdateDuePaymentsOnLogin',
    //     ],
    // ];
    // protected $listen = [
    //     Registered::class => [
    //         SendEmailVerificationNotification::class,
    //     ],
    // ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }



}
