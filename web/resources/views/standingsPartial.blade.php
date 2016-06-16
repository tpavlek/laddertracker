<table>
    <thead>
    <tr>
        <th>Rank</th>
        <th>Player</th>
        <th>LadderHeroes Points</th>
    </tr>
    </thead>
    <tbody>
    @forelse($users as $index => $user)
        <tr>
            <td>{{ $index + 1 }}.</td>
            <td><a href="{{ $user->getBnetUrl() }}">{{ $user->getDisplayName() }}</a></td>
            <td>{{ $user->getHeroPoints()->toString() }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3"><em>No users to show!</em></td>
        </tr>
    @endforelse
    </tbody>
</table>
