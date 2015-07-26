@extends('layout')

@section('title')
    History
@stop

@section('content')
    <div class="info-panel registered-users">
        @forelse($months as $month)
            <h2>Standings for month ended on: {{ $month->getEndDate()->getDate()->toDateString() }}</h2>
            <hr />
            @include('standingsPartial', [ 'users' => $month->getUsers() ])
        @empty
            <h2>There are no past months yet!</h2>
        @endforelse
    </div>



@stop
