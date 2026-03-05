@extends('layout')

@section('title', 'Admin panel - login')

@section('main')
    @if($errors->any())
        <span style="color:red">{{ $errors->first() }}</span>
    @endif
    <form action="/admin/login" name="admin-form" method='POST' class="admin__add-record">
        @csrf

        <label>
            <p>Login:</p>
            <input type="text" name="login" minlength="3" maxlength="12" required />
        </label>
        <label>
            <p>Password:</p>
            <input type="password" name="password" minlength="3" maxlength="12" required />
        </label>
        <button type="submit" class="admin-btn">Login</button>
    </form>
    <a href='/' class='back-btn'>Back to Main page</a>
@endsection