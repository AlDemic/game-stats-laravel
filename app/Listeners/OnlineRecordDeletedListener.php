<?php

namespace App\Listeners;

use App\Events\OnlineRecordDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OnlineRecordDeletedListener implements ShouldQueue
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
    public function handle(OnlineRecordDeleted $event): void
    {
        //write log
        Log::channel('admin_action')->info('Online record deleted', [
            'id' => $event->record->id,
            'game_id' => $event->record->game_id,
            'date' => $event->record->date,
            'stat' => $event->record->stat,
            'source' => $event->record->source,
            'created_at' => now()
        ]);
    }
}
