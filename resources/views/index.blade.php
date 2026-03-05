@extends('layout')

@section('title', 'Game Stats')

@section('main')
    <h2>Game statistics project<h2><br/>
    <h3>Abilities:</h3><br/>
    <ul>
        <li>Various stats: income, online, etc</li>
        <li>Various filters: average per all time, per month, etc</li>
        <li>Add records by yourself: start parser/take from json/by form</li>
        <li>Add games with logo and url</li>
        <li>Games from db are headers nav - automatically</li>
    </ul>
    <br/>
    <a href='/admin' class="admin-btn">Admin panel</a>
@endsection

