<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Game;

//EVENTS
use App\Events\OnlineRecordAdded;
use Illuminate\Support\Facades\Event;

class AddOnlineRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_online_record(): void
    {
        //fake event 
        Event::fake();

        //admin
        session()->put('is_admin', true);

        //make fake game in games
        $game = Game::factory()->create();

        //record example
        $record = [
            'stat' => 'online',
            'id' => $game->id,
            'date' => '2026-01',
            'stat_number' => 12,
            'source' => 'test'
        ];

        //send json req
        $response = $this->postJson('/admin/api/add-record-online', $record);

        //check answer
        $response->assertStatus(201)
                ->assertJson([
                    'status' => 'ok',
                    'msg' => 'Record is added to DB'
                ]);
        
        //check db
        $this->assertDatabaseHas('onlines', [
            'game_id' => $record['id'],
            'date' => $record['date'] . '-01',
            'stat' => $record['stat_number'],
            'source' => $record['source']
        ]);

        //check event
        Event::assertDispatched(OnlineRecordAdded::class);
    }
}
