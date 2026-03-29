<?php

namespace App\Listeners;

use App\Events\IncomeRecordDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class IncomeRecordDeletedListener implements ShouldQueue
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
    public function handle(IncomeRecordDeleted $event): void
    {
        //write log
        Log::channel('admin_action')->info('Income record deleted', [
            'id' => $event->record->id,
            'game_id' => $event->record->game_id,
            'date' => $event->record->date,
            'stat' => $event->record->stat,
            'source' => $event->record->source,
            'created_at' => now()
        ]);
    }
}
