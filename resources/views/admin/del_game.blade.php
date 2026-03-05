@extends('layout')

@section('title', 'Admin - delete game')

@section('main')
    <div class="sys-msg"></div>
    <form id="del-game" class="admin__add-game">
        <label>
            <b>Game ID:</b>
            <input type="number" name="id" minlength="1" placeholder="Put game's id to delete" required/>
        </label>
        <button type="submit" class="admin-btn">Delete game</button>
    </form>
    <!--Admin BACK block-->
    @include('admin.additional.back_block')
@endsection

@section('scripts')
    @vite('resources/js/admin/games.js')
@endsection
