@extends('layout')

@section('title')
    Home
@stop

@section('content')
    @if(!$naMessage->isEmpty())
        <div class="notification success">
            <h2 style="color:darkblue;">North America</h2>
            {!! $naMessage !!}
        </div>
    @endif

    @if(!$euMessage->isEmpty())
        <div class="notification success">
            <h2 style="color:darkblue;">Europe</h2>
            {!! $euMessage !!}
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
