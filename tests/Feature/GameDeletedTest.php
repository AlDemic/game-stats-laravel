<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Game;

//EVENTS
use App\Events\GameDeleted;
use Illuminate\Support\Facades\Event;

class GameDeletedTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_deleted_from_db(): void
    {
        //fake event
        Event::fake();

        //admin
        session()->put('is_admin', true);

        //make game in db
        $game = Game::factory()->create([
            'title' => 'Game Test',
            'year' => 2020,
            'pic' => 'test.png',
            'url' => 'test'
        ]);

        //make post by json
        $request = $this->postJson('/admin/api/del-game', [
            'id' => $game->id
        ]);

        //check json answer
        $request->assertStatus(200)
                ->assertJson([
                    'status' => 'ok',
                    'msg' => 'Game <b><i>Game Test</i></b> is deleted from db.'
                ]);

        //check db
        $this->assertSoftDeleted('games', [
            'id' => $game->id
        ]);

        //check event
        Event::assertDispatched(GameDeleted::class);
    }
}
