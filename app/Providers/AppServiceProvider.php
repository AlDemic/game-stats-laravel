<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Game;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //take games from DB for header list
        View::composer('layout', function($navList) {
            $gamesList = Cache::rememberForever('nav.games', function() {
                return Game::select('title', 'url', 'pic')->get();
            });
            
            $navList->with('gamesList', $gamesList);
        });
    }
}
