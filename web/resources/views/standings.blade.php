@extends('layout')

@section('title')
Standings
@stop

@section('content')

    <div>
        <a href="{{ URL::route('standings', \Depotwarehouse\BattleNetSC2Api\Region::America) }}" class="button @if($region->equals(\Depotwarehouse\LadderTracker\ValueObjects\Region::america())) error @endif">
            {{ \Depotwarehouse\LadderTracker\ValueObjects\Region::america()->niceString() }}
        </a>

        <a href="{{ URL::route('standings', \Depotwarehouse\BattleNetSC2Api\Region::Europe) }}" class="button @if($region->equals(\Depotwarehouse\LadderTracker\ValueObjects\Region::europe())) error @endif">
            {{ \Depotwarehouse\LadderTracker\ValueObjects\Region::europe()->niceString() }}
        </a>
    </div>

    <div class="info-panel registered-users">
        <h1>Current {{ $region->niceString() }} Rankings</h1>
        @include('standingsPartial')
    </div>
@stop
