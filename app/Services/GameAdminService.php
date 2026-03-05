<?php

namespace App\Services;

//MODELS
use App\Models\Game;

//EVENTS
use App\Events\GameAdded;
use App\Events\GameDeleted;

//ADDITIONAL
use Illuminate\Support\Str;

class GameAdminService
{
    //games list for header
    public function getGamesList() {
        return Game::all();
    }

    //add game to db
    public function addGameToDb($validated, $logo) {
        //save logo in store
        if($logo) {
            $pic_path = $logo->store('logo', 'public');
        }

        //save to db
        $game = Game::create([
            'title' => $validated['title'],
            'year' => $validated['year'],
            'pic' => $pic_path,
            'url' => Str::slug(trim($validated['title']))
        ]);

        //write log
        event(new GameAdded($game));

        return $game;
    }

    //del game from db
    public function delGameFromDb($validated) {
        $game = Game::findOrFail($validated['id']);
        $game->delete();

        //write log
        event(new GameDeleted($game));

        return $game;
    }
}
