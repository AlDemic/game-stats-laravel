<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Income;
use App\Models\Game;

//EVENTS
use App\Events\IncomeRecordDeleted;
use Illuminate\Support\Facades\Event;

class DeleteIncomeOneRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_one_record_income(): void
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
        Income::factory()->create($record);

        //fake json request to delete
        $post_date = substr($record['date'], 0, 7);
        $request = $this->postJson('/admin/api/del-record-income/one', [
            'stat' => 'income',
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
        $this->assertSoftDeleted('incomes', $record);

        //check event
        Event::assertDispatched(IncomeRecordDeleted::class);
    }
}
