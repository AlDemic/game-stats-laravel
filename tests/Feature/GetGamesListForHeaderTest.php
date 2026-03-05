<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

//MODELS
use App\Models\Game;

class GetGamesListForHeaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_games_list_for_header(): void
    {
        //make fake games
        Game::factory()->create();

        $response = $this->get('/api/games-list');

        $response->assertStatus(200)
                ->assertJson([
                    'status' => 'ok'
                ])
                ->assertJsonStructure([
                    'status',
                    'gamesList' => [
                        '*' => [
                            'title',
                            'year',
                            'pic',
                            'url'
                        ]
                    ]
                ]);
    }
}
