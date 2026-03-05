@extends('layout')

@section('title', 'Admin - delete income record')

@section('main')
    @if($games)
        <div class="games-list">@include('admin.additional.games_list_id_title')</div>
    @endif
    <div class="sys-msg"></div>
    <!--block to see game records per month from db-->
    <div class="month-info">
        <form id="month-info">
            <input type="hidden" name="stat" value="income">
            <label>
                <b>Game ID:</b>
                <input type="number" name="id" minlength="1" maxlength="10" placeholder="Put game id" required/>
            </label>
            <label>
                <b>Month:</b>
                <input type="month" name="date" required/>
            </label>
            <button type="submit" class="admin-btn">Show records</button>
        </form>
        <div class="month-info__records"></div>
    </div>

    @include('admin.additional.records_del_btns_block')
    
    @if(request()->mode === 'one-record')
        <form id="del-record-income-one" class="admin__add-record">
            <input type="hidden" name="stat" value="income" />
            @include('admin.additional.del_one_record_block')
            @include('admin.additional.del_record_block')
        </form>
    @elseif(request()->mode === 'month-record')
        <form id="del-record-income-month" class="admin__add-record">
            <input type="hidden" name="stat" value="income" />
            @include('admin.additional.del_month_record_block')
        </form> 
    @else
        <span>Select any mode</span>
    @endif
    <!--Admin BACK block-->
    @include('admin.additional.back_block')
@endsection

@section('scripts')
    @vite('resources/js/admin/game_records.js')
@endsection
