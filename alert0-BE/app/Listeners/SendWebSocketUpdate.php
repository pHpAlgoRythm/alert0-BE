<?php

namespace App\Listeners;

use App\Events\pendingUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;


class SendWebSocketUpdate
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(pendingUser $event): void
    {
        Http::post('http://localhost:3001/broadcast', [
            'user' => $event->user
        ]);
    }
}
