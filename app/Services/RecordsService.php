<?php

namespace App\Services;

//MODELS
use App\Models\Online;
use App\Models\Income;
use App\Models\Game;

//EVENTS
use App\Events\OnlineRecordAdded;
use App\Events\IncomeRecordAdded;
use App\Events\OnlineRecordDeleted;
use App\Events\IncomeRecordDeleted;


class RecordsService
{
    //array for stats and functions(test)
    protected $statsClassArray = [
        'online' => Online::class,
        'income' => Income::class,
    ];

    //array for event: record added
    protected $statsClassArrayEventAdded = [
        'online' => OnlineRecordAdded::class,
        'income' => IncomeRecordAdded::class,
    ];

    //array for event: record deleted
    protected $statsClassArrayEventDeleted = [
        'online' => OnlineRecordDeleted::class,
        'income' => IncomeRecordDeleted::class,
    ];

    //get id and game's title for admin action
    public function getGamesList() {
        return Game::select('id', 'title')->get();
    }

    //get game's records per month
    public function getGameRecords($validated) {
        $modelClass = $this->statsClassArray[$validated['stat']];

        //get records
        return $modelClass::where('game_id', $validated['id'])->where('date', $validated['date'])->get();
    }
    
    public function addRecord($validated)
    {
        //record 
        $recordArray = [
                    'game_id' => $validated['id'],
                    'date' => $validated['date'],
                    'stat' => $validated['stat_number'],
                    'source' => $validated['source']
        ];

        //take class depends on stat from array
        $modelClass = $this->statsClassArray[$validated['stat']];

        //add to db
        $record = $modelClass::create($recordArray);

        //write to log
        $modelLog = $this->statsClassArrayEventAdded[$validated['stat']];
        event(new $modelLog($record));
    }

    //del one record from db
    public function delOneRecord($validated) {
        //record
        $recordArray = [
            'game_id' => $validated['gameId'],
            'source' => $validated['source'],
            'date' => $validated['date']
        ];
        
        //take class depends on stat from array
        $modelClass = $this->statsClassArray[$validated['stat']];

        //del from db
        $delRecord = $modelClass::where($recordArray)->firstOrFail(); 

        //delete
        $delRecord->forceDelete();

        //write to log
        $modelLog = $this->statsClassArrayEventDeleted[$validated['stat']];
        event(new $modelLog($delRecord));
    }

    //del month record from db
    public function delMonthRecord($validated) {
        //record
        $recordArray = [
            'game_id' => $validated['gameId'],
            'date' => $validated['date']
        ];
        
        //take class depends on stat from array
        $modelClass = $this->statsClassArray[$validated['stat']];

        //get records from db
        $records = $modelClass::where($recordArray)->get(); 

        //model for log
        $modelLog = $this->statsClassArrayEventDeleted[$validated['stat']];

        //delete each record and write to log
        foreach($records as $record) {
            //delete
            $record->forceDelete();

            //write log
            event(new $modelLog($record));
        }    
    }
}
