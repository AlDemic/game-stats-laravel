<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParserService;

class ParserController extends Controller
{
    //start selected parser
    public function startParser(ParserService $service, Request $request) {
        //parser from form
        $parserSelected = $request->validate([
            'parser-run' => 'required|string'
        ]);

        //run parser
        $parserResult = $service->runParser($parserSelected['parser-run']);

        //send back json answer for user
        return response()->json([
            'status' => 'ok',
            'msg' => $parserResult
        ], 200);
    }

    //load selected data from json to db
    public function loadJsonRaw(ParserService $service, Request $request) {
        //check form params
        $validated = $request->validate([
            'id' => 'required|integer|min:1|exists:games,id',
            'source' => 'required|string|min:3|max:12',
            'stat' => 'required|string',
            'date-from' => 'required|date|date_format:Y-m',
            'date-to' => 'required|date|date_format:Y-m',
            'json-raw' => 'required|string'
        ]);

        //start service
        $result = $service->loadJsonRaw($validated);

        //send back json answer for user
        return response()->json([
            'status' => 'ok',
            'msg' => $result
        ], 200);
    }
}
