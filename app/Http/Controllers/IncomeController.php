<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//VALIDATION
use App\Http\Requests\AddIncomeRecordRequest;
use App\Http\Requests\DelIncomeOneRecordRequest;
use App\Http\Requests\DelIncomeMonthRecordRequest;
use App\Http\Requests\GetIncomeGameRecordsRequest;

//RESOURCES
use App\Http\Resources\IncomeResource;

use App\Services\RecordsService;

class IncomeController extends Controller
{
    //get game id and title
    public function loadStatPage(Request $request, RecordsService $service) {
        //list with id and title
        $games = $service->getGamesList();
        
        $view_array = [
            'admin/add-record-income' => 'admin.add_record_income',
            'admin/del-record-income' => 'admin.del_record_income',
        ];

        //take from url address for view
        $url = $request->path();
        return view($view_array[$url], ['games' => $games]);
    }

    //get game's records of online
    public function getGameRecords(GetIncomeGameRecordsRequest $request, RecordsService $service) {
        //validate form
        $validated = $request->validated();

        //get records
        $records = $service->getGameRecords($validated);

        //send back
        return response()->json([
            'status' => 'ok',
            'records' => IncomeResource::collection($records)
        ]);
    } 

    //add game's record to db
    public function addRecord(AddIncomeRecordRequest $request, RecordsService $service) {
        //check user's form
        $validated = $request->validated();

        //add to DB + record in log
        $service->addRecord($validated);

        //json answer for admin
        return response()->json([
            'status' => 'ok',
            'msg' => 'Record is added to DB'
        ], 201);
    }

    //del game's record from db
    public function delOneRecord(DelIncomeOneRecordRequest $request, RecordsService $service) {
        //check user form
        $validated = $request->validated();

        //delete
        $service->delOneRecord($validated);

        //inform user
        return response()->json([
            'status' => 'ok',
            'msg' => 'Record is deleted'
        ], 200);
    }

    //del game's record from db
    public function delMonthRecord(DelIncomeMonthRecordRequest $request, RecordsService $service) {
        //check user form
        $validated = $request->validated();

        //delete
        $service->delMonthRecord($validated);

        //inform user
        return response()->json([
            'status' => 'ok',
            'msg' => 'Record is deleted'
        ], 200);
    }
}
