@extends('layout')

@section('title', 'Admin - parser')

@section('main')
    <div class="sys-msg"></div>
    <div class="games-list"></div>
        <div class="sys-msg"></div>
        <!--FORMS for parser selection-->
        <div class='parser'>
            <div class='parser__btns-select'>
                <a href='?type=select-parser' class='admin-btn'>Select parser</a>
                <a href='?type=load-json' class='admin-btn'>Load JSON</a>
            </div>
            @if(request()->type === 'select-parser')
            <!--select parser-->
            <form id="parser-run" class="parser-form">
                <input type="hidden" name="mode" value="run" />
                <h3 style="color:red">Choose which parser to run:</h3>
                <select name="parser-run">
                    <option value="">Select parser</option>
                    <option value="zzz-activeplayerio">ZZZ - activePlayer.io</option>
                </select>
                <button type="submit" class="admin-btn">Run</button>
            </form>
            @elseif(request()->type === 'load-json')
            <!--Select json parser raw to load in db-->
            <form id="parser-loadJson" class="parser-form">
                <input type="hidden" name="mode" value="load" />
                <small style="color:red">Select json raw file to load in db. <br/>To take only 1 date - select same date FROM - TO</small>
                <label>
                    <b>Game ID:</b>
                    <input type="number" name="id" minlength="1" maxlength="10" placeholder="Put game id" required/>
                </label>
                <label>
                    <b>Source(for db column):</b>
                    <input type="text" name="source" minlength="3" maxlength="128" placeholder="Put game source 3-128 length" required/>
                </label>
                <label>
                    <b>Stat:</b>
                    <select name="stat" id="select__stat">
                        <option value="">Choose stat</option>
                        <option value="online">Online</option>
                        <option value="income">Income</option>
                    </select>
                </label>
                <label>
                    <b>Date FROM</b>
                    <input type="month" name="date-from" required/>
                </label>
                <label>
                    <b>Date TO:</b>
                    <input type="month" name="date-to" required/>
                </label>
                <label>
                    <b>Select JSON raw:</b>
                    <select name="json-raw">
                        <option value="">Select JSON</option>
                        <option value="zzz-activeplayerio">ZZZ - activePlayer.io(online)</option>
                    </select>
                </label>
                <button type="submit" class="admin-btn">Load JSON</button>
            </form>
            @else
                <span>Choose any parser's operation</span>
            @endif
        </div>
    <!--Admin BACK block-->
    @include('admin.additional.back_block')
@endsection

@section('scripts')
    @vite('resources/js/admin/parser.js')
@endsection
