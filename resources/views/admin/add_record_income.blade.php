@extends('layout')

@section('title', 'Admin - add income record')

@section('main')
    @if($games)
        <div class="games-list">@include('admin.additional.games_list_id_title')</div>
    @endif
    <div class="sys-msg"></div>
    <form id="add-record-income" class="admin__add-record">
        <input type="hidden" name="stat" value="income" />
        @include('admin.additional.add_record_block')
    </form>
    <!--Admin BACK block-->
    @include('admin.additional.back_block')
@endsection

@section('scripts')
    @vite('resources/js/admin/game_records.js')
@endsection
