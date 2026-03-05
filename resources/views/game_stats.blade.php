@extends('layout')

@section('title', 'Game stats')

@section('main')
    <div class='main__title'>
        <!--game info header(game name, filters)-->
        <div class="main__title-block">
            <h3 class='main__title-game'>
                @if(isset($game))
                    {{ $game->title }}
                @else
                    'No have game'
                @endif
            </h3>
            <span class="main__title-game-stat">
                @if(isset($stat))
                    <i>[ {{ $stat }} - info ]</i>
                @endif
            </span>
        </div>
        <div class='main__title-filters'>
            @if(isset($stat))
                <a href="{{ request()->fullUrlWithQuery(['filter' => 'aver-all', 'date' => null]) }}" class="button">Average all</a>
                <a href="{{ request()->fullUrlWithQuery(['filter' => 'aver-month']) }}"  class="button">Average monthly</a>
            @else
                <span>Choose any stat to see filters</span>
            @endif
        </div>
    </div>
    <div class="main__content">
        <!--info for online, income, etc-->
        <div class='main__content-stats'>
            @if(isset($game))
                <a href="?stat=online" class="button">online</a>
                <a href='?stat=income' class="button">income</a>
            @endif
        </div>
        <div class='main__content-info'>
            @if(isset($stat) && $filter === 'aver-month')
                @include('date_select_form')
                <span>Average per this month: {{ isset($result) ? $result : 0 }}</span>
            @elseif(isset($stat) && $filter === 'aver-all')
                <span>Average online for all time: {{ isset($result) ? $result : 0 }}</span>
            @else
                <span>Select any filter to see info</span>
            @endif
        </div>
    </div>
    <div class="game-back-btn"></div>
@endsection
