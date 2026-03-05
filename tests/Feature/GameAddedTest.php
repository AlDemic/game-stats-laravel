<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

//PIC 
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

//EVENTS
use App\Events\GameAdded;
use Illuminate\Support\Facades\Event;

class GameAddedTest extends TestCase
{
    use RefreshDatabase; //clean db

    public function test_added_new_game_to_db(): void
    {
        //fake event
        Event::fake();

        //admin
        session()->put('is_admin', true);
        
        //fake storage
        Storage::fake('public');

        //fake pic
        $pic = UploadedFile::fake()->image('test-game.png');

        //make request
        $request = $this->postJson('/admin/api/add-game', [
            'title' => 'Test Game',
            'year' => '2020',
            'logo' => $pic
        ]);

        //check answer
        $request->assertStatus(201)
                ->assertJson([
                    'status' => 'ok',
                    'msg' => 'Game <b><i>Test Game</i></b> is added to db.'
                ]);
        
        //check exist in db
        $this->assertDatabaseHas('games', [
            'title' => 'Test Game',
            'year' => '2020',
        ]);

        //check event
        Event::assertDispatched(GameAdded::class);
    }
}
