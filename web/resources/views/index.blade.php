@extends('layout')

@section('title')
    Home
@stop

@section('content')
    @if(!$message->isEmpty())
        <div class="notification success">
            {!! $message !!}
        </div>
    @endif

<div class="pure-g">
    <div class="pure-u-lg-1-2 pure-u-1">
        @include('ladderPartial', [ 'users' => $naUsers, 'ladder_title' => "North America" ])
    </div>

    <div class="pure-u-lg-1-2 pure-u-1">
        @include('ladderPartial', [ 'users' => $euUsers, 'ladder_title' => "Europe" ])
    </div>

</div>

@stop
