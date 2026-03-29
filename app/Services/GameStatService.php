<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Online;
use App\Models\Income;

class GameStatService
{
    //models array
    protected $modelsArray = [
        'online' => Online::class,
        'income' => Income::class
    ];

    //main class for controller
    public function getStats(Game $game, $stat, $filter, $date) {
        //call func depends on stat
        switch($filter) {
            case 'aver-all':
                $result = $this->getAverAll($game, $stat);
                break;
            case 'aver-month':
                $result = $this->getAverMonthly($game, $stat, $date);
                break;
            default:
                $result = null;
        }

        return ['game' => $game, 'result' => round($result, 1)];
    }

    //get average per all month
    protected function getAverAll(Game $game, $stat) {
        //get model depends on $stat
        $model = $this->modelsArray[$stat];

        //get result from db
        return $model::where('game_id', $game->id)->avg('stat');
    }

    //get average per month
    protected function getAverMonthly(Game $game, $stat, $date) {
        if(!$date) return null;
        [$year, $month] = explode('-', $date);

        //get model depends on $stat
        $model = $this->modelsArray[$stat];
         
        return $model::where('game_id', $game->id)->whereYear('date', $year)->whereMonth('date', $month)->avg('stat');
    }
}
