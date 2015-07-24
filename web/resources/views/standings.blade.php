@extends('layout')

@section('title')
Standings
@stop

@section('content')
    <div class="info-panel registered-users">
        <h1>Current Tournament Rankings</h1>
        <table>
            <thead>
            <tr>
                <th>Rank</th>
                <th>Player</th>
                <th>LadderHeroes Points</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}.</td>
                    <td><a href="{{ $user->getBnetUrl() }}">{{ $user->getDisplayName() }}</a></td>
                    <td>{{ $user->getHeroPoints()->toString() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
