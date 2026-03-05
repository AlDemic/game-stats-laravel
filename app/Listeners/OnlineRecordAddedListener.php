<?php

namespace App\Listeners;

use App\Events\OnlineRecordAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OnlineRecordAddedListener
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
    public function handle(OnlineRecordAdded $event): void
    {
        //write log
        Log::channel('admin_action')->info('Online record added', [
            'id' => $event->record->id,
            'game_id' => $event->record->game_id,
            'date' => $event->record->date,
            'stat' => $event->record->stat,
            'source' => $event->record->source,
            'created_at' => now()
        ]);
    }
}
