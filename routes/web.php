<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\OnlineController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\AdminAuthenticationController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ParserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdmin;

//GET ROUTS
Route::get('/', fn() => view('index')); //main page
Route::get('/games/{game}', [GameController::class, 'getGameByUrl']); //game page with stats 

//API BLOCK
Route::prefix('api')->group(function() {
    Route::get('/games-list', [GameController::class, 'getGamesList']); //get games list to render navigation in header
});

//ADMIN BLOCK
Route::prefix('admin')->group(function() {
    //ADMIN AUTHENTICATION
    Route::get('/login', [AdminAuthenticationController::class, 'isAdmin']);
    Route::post('/login', [AdminAuthenticationController::class, 'adminLogin']);

    Route::middleware([CheckAdmin::class])->group(function() {
        //GET ROUTS
        Route::get('/', fn() => view('admin.index')); //admin page
        Route::get('/add-game', fn() => view('admin.add_game')); //add game
        Route::get('/del-game', fn() => view('admin.del_game')); //del game
        Route::get('/add-record-online', [OnlineController::class, 'loadStatPage']); //add online record
        Route::get('/add-record-income', [IncomeController::class, 'loadStatPage']); //add income record
        Route::get('/del-record-online', [OnlineController::class, 'loadStatPage']); //del online record
        Route::get('/del-record-income', [IncomeController::class, 'loadStatPage']); //del income record
        Route::get('/parser', fn() => view('admin.parser')); //parser menu

        //API ADMIN BLOCK
        Route::prefix('api')->group(function() {
            Route::post('/records/online', [OnlineController::class, 'getGameRecords']); //get game's online records list
            Route::post('/records/income', [IncomeController::class, 'getGameRecords']); //get game's income records list
            Route::post('/add-game', [GameController::class, 'addGame']); //add new game
            Route::post('/del-game', [GameController::class, 'delGame']); //delete game
            Route::post('/add-record-online', [OnlineController::class, 'addRecord']); //add online record to db
            Route::post('/add-record-income', [IncomeController::class, 'addRecord']); //add income record to db
            Route::post('/del-record-online/one', [OnlineController::class, 'delOneRecord']); //del one online record in db
            Route::post('/del-record-income/one', [IncomeController::class, 'delOneRecord']); //del one income record in db
            Route::post('/del-record-online/month', [OnlineController::class, 'delMonthRecord']); //del online record per month in db
            Route::post('/del-record-income/month', [IncomeController::class, 'delMonthRecord']); //del income record per month in db

            Route::post('/parser/run', [ParserController::class, 'startParser']); //start selected parser
            Route::post('/parser/load-json', [ParserController::class, 'loadJsonRaw']); //start selected parser
        });
    });
});