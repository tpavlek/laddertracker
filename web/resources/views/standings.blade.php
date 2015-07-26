@extends('layout')

@section('title')
Standings
@stop

@section('content')
    <div class="info-panel registered-users">
        <h1>Current Tournament Rankings</h1>
        @include('standingsPartial')
    </div>
@stop
