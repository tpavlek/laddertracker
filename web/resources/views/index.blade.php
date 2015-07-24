@extends('layout')

@section('title')
    Home
@stop

@section('content')
<div class="info-panel registered-users">
    <h1>Current Ladder Rankings</h1>
    <table>
        <thead>
        <tr>
            <th>Rank</th>
            <th>Player</th>
            <th>Ladder Rank</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $index => $user)
        <tr>
            <td>{{ $index + 1 }}.</td>
            <td><a href="{{ $user->getBnetUrl() }}">{{ $user->getDisplayName() }}</a></td>
            <td>@if($user->getRank()->getLadderRank() > 0) <strong>{{ $user->getRank()->getLadderRank() }}</strong> ({{ $user->getRank()->getLadderPoints() }} points) @else - @endif</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
