@extends('layout')

@section('title', 'Admin panel')

@section('main')
    <div class="admin-menu">    
        <h3>Choose admin action:</h3>
        <a href='admin/add-game' class="admin-btn">Add game</a>
        <a href='admin/del-game' class="admin-btn">Delete game</a>
        <a href='admin/add-record-online' class="admin-btn">Add online record</a>
        <a href='admin/add-record-income' class="admin-btn">Add income record</a>
        <a href='admin/del-record-online' class="admin-btn">Delete game's online record</a>
        <a href='admin/del-record-income' class="admin-btn">Delete game's income record</a>
        <a href='admin/parser' class="admin-btn">Parser</a>
        <a href='/' class="back-btn">Back to Main</a>
    </div>
@endsection