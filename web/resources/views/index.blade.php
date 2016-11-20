@extends('layout')

@section('title')
    Home
@stop

@section('content')

<div class="pure-g">
    <div class="pure-u-lg-1-2 pure-u-1">
        @include('ladderPartial', [ 'users' => $naUsers, 'ladder_title' => "North America", 'lockDate' => $naLockDate ])
    </div>

    <div class="pure-u-lg-1-2 pure-u-1">
        @include('ladderPartial', [ 'users' => $euUsers, 'ladder_title' => "Europe", 'lockDate' => $euLockDate ])
    </div>

</div>

@stop
