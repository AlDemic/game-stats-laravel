@php
    $logoHeight = 70;
    $logoWidth = 150;
@endphp
<header class='header'>
    <nav class='nav'>
        @if(isset($gamesList) && $gamesList->isNotEmpty())
            @foreach($gamesList as $game)
                <button class="btn-56" onclick="location.href='/games/{{$game->url}}'">{{$game->title}}</button>
            @endforeach
        @else
            <b>No games</b>
        @endif
    </nav>

    <div class='header__title'>
        <h1 class='header__title'><a href='/'>Game Stats</a></h1>
    </div>

    <div class="logo__pic">
        @php
            $currentGame = request()->route('game');
        @endphp
        @if($currentGame)
            <img src="/storage/{{$currentGame->pic}}" height="{{$logoHeight}}" width="{{$logoWidth}}" alt="{{$currentGame->title}} logo" />
        @else
            <img src='/storage/logo/main-logo.png' height="{{$logoHeight}}" width="{{$logoWidth}}" alt="Site logo" />
        @endif
    </div>
</header>
