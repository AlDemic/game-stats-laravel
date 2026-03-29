<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use App\Services\ParserService;
use App\Models\ParserLog;

class ParserStartJob implements ShouldQueue
{
    use Queueable;

    //tries
    public $tries = 2;

    //delay for tries
    public function backoff() {
        return [5, 10];
    }

    protected string $parserName;

    public function __construct(string $parserName)
    {
        $this->parserName = $parserName;
    }

    /**
     * Execute the job.
     */
    public function handle(ParserService $service): void
    {
        //create log in db for creating
        $parserLog = ParserLog::create([
            'parser_title' => $this->parserName,
            'status' => 'started'
        ]);
        
        //start parser
        $result = $service->runParser($this->parserName);

        //check result and update record depends on result
        $parser_status = ($result === 'ok') ? 'done' : 'fail';

        $parserLog->update([
            'status' => $parser_status
        ]);
    }

    //failed job
    public function failed(\Throwable $e) {
        Log::error("Job parser is failed {$e->getMessage()}");
    }
}
