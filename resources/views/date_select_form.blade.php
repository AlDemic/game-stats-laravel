<!-- FORM for game_stats Date Select -->
<form method="GET" action="/games/{{ $game->url }}">
    <input type="hidden" name="stat" value="{{ request('stat') }}"/>
    <input type="hidden" name="filter" value="{{ request('filter') }}"/>

    <label>
        Select month and year[1970-2030]:
        <input type="month" name="date" min="1970-01" max="2030-01" value="{{ request('date') }}"/>
    </label>
    <br/>
    <button type="submit" class="admin-btn">Get info</button>
</form>