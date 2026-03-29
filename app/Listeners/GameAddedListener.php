<?php

namespace App\Listeners;

use App\Events\GameAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class GameAddedListener implements ShouldQueue
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
    public function handle(GameAdded $event): void
    {
        //write log
        Log::channel('admin_action')->info('Game added', [
            'id' => $event->game->id,
            'title' => $event->game->title,
            'year' => $event->game->year,
            'pic' => $event->game->pic,
            'created_at' => now()
        ]);
    }
}
