<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Events\GameDeleted;

class GameDeletedListener implements ShouldQueue
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
    public function handle(GameDeleted $event): void
    {
        //write log
        Log::channel('admin_action')->info('Game deleted', [
            'id' => $event->game->id,
            'title' => $event->game->title,
            'year' => $event->game->year,
            'pic' => $event->game->pic,
            'created_at' => now()
        ]);
    }
}
