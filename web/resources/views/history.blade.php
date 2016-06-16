@extends('layout')

@section('title')
    History
@stop

@section('content')
    <div class="pure-g">
        @forelse($months as $month)
            <div class="pure-u-1 pure-u-lg-1-2">
                <div class="info-panel registered-users ladder-ranking">
                    <h2>Standings for {{ $month->region()->niceString() }} month ended on: {{ $month->getEndDate()->getDate()->toDateString() }}</h2>
                    @include('standingsPartial', [ 'users' => $month->getUsers() ])
                </div>
            </div>
        @empty
            <div class="pure-u-1">
                <div class="info-panel registered-users ladder-ranking">
                    <h2>There are no past months yet!</h2>
                </div>
            </div>

        @endforelse
    </div>
@stop
