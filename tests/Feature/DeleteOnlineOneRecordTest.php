<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Online;
use App\Models\Game;

//EVENTS
use App\Events\OnlineRecordDeleted;
use Illuminate\Support\Facades\Event;

class DeleteOnlineOneRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_one_record_online(): void
    {
        //fake event
        Event::fake();

        //admin
        session()->put('is_admin', true);

        //fake game data
        $game = Game::factory()->create([
            'id' => 1
        ]);

        //fake record data
        $record = [
            'game_id' => $game['id'],
            'date' => '2026-01-01',
            'stat' => 10,
            'source' => 'test'
        ];

        //make fake record in db
        Online::factory()->create($record);

        //fake json request to delete
        $post_date = substr($record['date'], 0, 7);
        $request = $this->postJson('/admin/api/del-record-online/one', [
            'stat' => 'online',
            'gameId' => $record['game_id'],
            'source' => $record['source'],
            'date' => $post_date
        ]);

        //check answer
        $request->assertStatus(200)
                ->assertJson([
                    'status' => 'ok',
                    'msg' => 'Record is deleted'
                ]);

        //check db
        $this->assertDatabaseMissing('onlines', $record);

        //check event
        Event::assertDispatched(OnlineRecordDeleted::class);
    }
}
