<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//VALIDATION
use App\Http\Requests\AddOnlineRecordRequest;
use App\Http\Requests\DelOnlineOneRecordRequest;
use App\Http\Requests\DelOnlineMonthRecordRequest;
use App\Http\Requests\GetOnlineGameRecordsRequest;

//RESOURCES
use App\Http\Resources\OnlineResource;

use App\Services\RecordsService;


class OnlineController extends Controller
{
    //get game id and title
    public function loadStatPage(Request $request, RecordsService $service) {
        //list with id and title
        $games = $service->getGamesList();
        
        $view_array = [
            'add-record-online' => 'admin.add_record_online',
            'del-record-online' => 'admin.del_record_online',
        ];

        //take from url address for view
        $url = substr($request->path(), 6);
        return view($view_array[$url], ['games' => $games]);
    }

    //get game's records of online
    public function getGameRecords(GetOnlineGameRecordsRequest $request, RecordsService $service) {
        //validate form
        $validated = $request->validated();

        //get records
        $records = $service->getGameRecords($validated);

        //send back
        return response()->json([
            'status' => 'ok',
            'records' => OnlineResource::collection($records)
        ]);
    } 

    //add game's record to db
    public function addRecord(AddOnlineRecordRequest $request, RecordsService $service) {
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
    public function delOneRecord(DelOnlineOneRecordRequest $request, RecordsService $service) {
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
    public function delMonthRecord(DelOnlineMonthRecordRequest $request, RecordsService $service) {
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
