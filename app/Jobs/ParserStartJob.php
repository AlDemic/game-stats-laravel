<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\ParserService;
use App\Models\ParserLog;

class ParserStartJob implements ShouldQueue
{
    use Queueable;

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
}
