@foreach($games as $game)
    <div class="game-block">
        <p>Game Title: <b>{{$game->title}}</b> - ID: <b>{{$game->id}}</b></p><br/>
    </div>
@endforeach