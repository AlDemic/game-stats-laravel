<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Online;
use App\Models\Income;

class GameStatService
{
    //main class for controller
    public function getStats(string $url, $stat, $filter, $date) {
        //get game
        $game = Game::where('url', $url)->firstOrFail();

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
            switch($stat) {
                case 'online':
                    $result = Online::where('game_id', $game->id)->avg('stat');
                    break;
                case 'income':
                    $result = Income::where('game_id', $game->id)->avg('stat');
                    break;
                default:
                    $result = null;
            }
            return $result;           
    }

    //get average per month
    protected function getAverMonthly(Game $game, $stat, $date) {
            if(!$date) return null;
            [$year, $month] = explode('-', $date);
            
            switch($stat) {
                case 'online':
                    $result = Online::where('game_id', $game->id)->whereYear('date', $year)->whereMonth('date', $month)->avg('stat');
                    break;
                case 'income':
                    $result = Income::where('game_id', $game->id)->whereYear('date', $year)->whereMonth('date', $month)->avg('stat');
                    break;
                default:
                    $result = null;
            }

            return $result;
    }
}
