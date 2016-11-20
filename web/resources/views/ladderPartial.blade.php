<div class="info-panel registered-users ladder-ranking">
    <h1>{{ $ladder_title or "Ladder Rankings" }}</h1>
    @if($ladder_title == "Europe")
        <span style='color:orange'> EU countdown timer currently broken, wokring on fix!</span>
    @elseif($ladder_title == "North America")
        <span style='color:orange'>Next lock in : {{ $naLockDate }}</span>
    @endif
    @if($ladder_title == "Europe" && !$euMessage->isEmpty())
        <div class="notification success">
            {!! $euMessage !!}
        </div>
    @elseif($ladder_title == "North America" && !$naMessage->isEmpty())
        <div class="notification success">
            {!! $naMessage !!}
        </div>
    @endif
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
            <tr @if (\Carbon\Carbon::now()->subWeek()->gt($user->lastPlayed())) class="stale" @endif>
                <td>{{ $index + 1 }}.</td>
                <td><a href="{{ $user->getBnetUrl() }}">{{ $user->getDisplayName() }}</a> @if (\Carbon\Carbon::now()->subWeek()->gt($user->lastPlayed())) | <em>Last Game: {{ $user->lastPlayed()->format('M j') }}</em> @endif</td>
                <td>
                    @if($user->getRank()->getLadderRank() > 0 && $user->getRank()->getLadderRank() < 201)
                        <strong>{{ $user->getRank()->getLadderRank() }}</strong> ({{ $user->getRank()->getLadderPoints() }} points)
                        @if($user->lastChange() > 0)
                            <span style="color:green">+{{ $user->lastChange() }} ({{ $user->getTimeSinceLastGame() }})</span>
                        @elseif($user->lastChange() < 0)
                            <span style="color:red">{{ $user->lastChange() }} ({{ $user->getTimeSinceLastGame() }})</span>
                        @endif
                    @else - 
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3"><em>No users to show!</em></td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
