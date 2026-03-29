<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//VALIDATION
use App\Http\Requests\AddGameRequest;
use App\Http\Requests\DelGameRequest;

//RESOURCES
use App\Http\Resources\GameResource;

//API SERVICES
use App\Services\GameStatService;
use App\Services\GameAdminService;

//MODELS
use App\Models\Game;

class GameController extends Controller
{
    //get game by url
    public function getGameByUrl(Game $game, Request $request, GameStatService $service) {
        //get query from url
        $stat = $request->stat;
        $filter = $request->filter;
        $date = $request->date;

        //get game and result if exist stat and filter
        $serviceResult = $service->getStats($game, $stat, $filter, $date);

        //call blade page
        return view('game_stats', [
            'game' => new GameResource($serviceResult['game']),
            'stat' => $stat,
            'filter' => $filter,
            'date' => $date,
            'result' => $serviceResult['result']
        ]);
    }

    //get games list (using for header)
    public function getGamesList(GameAdminService $service) {
        $gamesList = $service->getGamesList();  
        
        //send back json
        return response()->json([
            'status' => 'ok',
            'gamesList' => GameResource::collection($gamesList),
        ], 200);
    }

    //add game to db by admin
    public function addGame(AddGameRequest $request, GameAdminService $service) {
        //validation user form
        $validated = $request->validated();

        //logo
        $logo = $request->file('logo');

        //save to db, store and write log
        $game = $service->addGameToDb($validated, $logo);

        //json answer for user
        return response()->json([
            'status' => 'ok',
            'msg' => "Game <b><i>$game->title</i></b> is added to db."
        ], 201);
    }

    //delete game from db by admin
    public function delGame(DelGameRequest $request, GameAdminService $service) {
        //validation user form
        $validated = $request->validated();

        $game = $service->delGameFromDb($validated);

        //json answer for user
        return response()->json([
            'status' => 'ok',
            'msg' => "Game <b><i>$game->title</i></b> is deleted from db."
        ], 200);
    }
}
