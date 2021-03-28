<?php

namespace App\Providers;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\ExampleEvent::class => [
            \App\Listeners\ExampleListener::class,
        ],
    ];

    public function boot(){
        Pivot::creating(function($pivot) {
            $pivot->id = Uuid::generate();
        });
    }
}
