<div class="info-panel registered-users ladder-ranking">
    <h1>{{ $ladder_title or "Ladder Rankings" }}</h1>
    <table>
        <thead>
        <tr>
            <th>Rank</th>
            <th>Player</th>
            <th>Ladder Rank</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}.</td>
                <td><a href="{{ $user->getBnetUrl() }}">{{ $user->getDisplayName() }}</a></td>
                <td>@if($user->getRank()->getLadderRank() > 0 && $user->getRank()->getLadderRank() < 201) <strong>{{ $user->getRank()->getLadderRank() }}</strong> ({{ $user->getRank()->getLadderPoints() }} points) @else - @endif</td>
            </tr>
        @empty
            <tr>
                <td colspan="3"><em>No users to show!</em></td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
