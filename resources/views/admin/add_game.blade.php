@extends('layout')

@section('title', 'Admin - add game')

@section('main')
    <div class="sys-msg"></div>
    <form id="add-game" class="admin__add-game" enctype="multipart/form-data">
        <label>
            <b>Game title:</b>
            <input type="text" name="title" minlength="3" maxlength="64" placeholder="Put title of game" required/>
        </label>
        <label>
            <b>Released year:</b>
            <input type="number" name="year" minlength="4" maxlength="4" placeholder="When published" required/>
        </label>
        <input type="file" name="logo" required/>
        <button type="submit" class="admin-btn">Add game</button>
    </form>
    <!--Admin BACK block-->
    @include('admin.additional.back_block')
@endsection

@section('scripts')
    @vite('resources/js/admin/games.js')
@endsection

