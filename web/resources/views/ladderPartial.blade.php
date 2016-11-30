<div class="info-panel registered-users ladder-ranking">
    <h1>{{ $ladder_title or "Ladder Rankings" }}</h1>
    @if($ladder_title == "Europe")
        <span style='color:orange'>Next lock in : <span id="euTimer">Loading . . .</span></span>
    @elseif($ladder_title == "North America")
        <span style='color:orange'>Next lock in : <span id="naTimer">Loading . . .</span></span>
        <script language="JavaScript">
            var naCount = {{ $naLockDate }};
            var euCount = {{ $euLockDate }};
            var counter = setInterval(timer, 1000);
            function timer() {
                if(naCount <= 0) {
                    document.getElementById("euTimer").innerHTML = "Ladder locked!";
                } else {
                    naCount = naCount - 1;
                    document.getElementById("naTimer").innerHTML = (formatCountdown(naCount));
                }
                if(euCount <= 0) {
                    document.getElementById("euTimer").innerHTML = "Ladder locked!";
                } else {
                    euCount = euCount - 1;
                    document.getElementById("euTimer").innerHTML = (formatCountdown(euCount));
                }
                if(naCount <= 0 && euCount <=0) {
                    clearInterval(counter);
                }

            }
            function formatCountdown(t) {
                var seconds = Math.floor(t % 60);
                var minutes = Math.floor((t/60) % 60);
                var hours = Math.floor((t/(60*60)) % 24);
                var days = Math.floor(t/(60*60*24));
                return days + ' days ' + hours + ' hours ' + minutes + ' minutes ' + seconds + ' seconds';
            }
        </script>

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
            <th>Last Change</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($users as $index => $user)
            <tr @if (\Carbon\Carbon::now()->subWeek()->gt($user->lastPlayed())) class="stale" @endif>
                <td>{{ $index + 1 }}.</td>
                <td><a href="{{ $user->getBnetUrl() }}">{{ $user->getDisplayName() }}</a> </td>
                <td>
                    @if($user->getRank()->getLadderRank() > 0 && $user->getRank()->getLadderRank() < 201)
                        <strong>{{ $user->getRank()->getLadderRank() }}</strong> ({{ $user->getRank()->getLadderPoints() }} points)
                    @else - 
                    @endif
                </td>
                <td>
                    @if (\Carbon\Carbon::now()->subWeek()->gt($user->lastPlayed()))
                        <em>Last Game: {{ $user->lastPlayed()->format('M j') }}</em>
                    @else
                        @if($user->lastChange() > 0)
                            <span style="color:green">+{{ $user->lastChange() }} ({{ $user->getTimeSinceLastGame() }})</span>
                        @elseif($user->lastChange() < 0)
                            <span style="color:red">{{ $user->lastChange() }} ({{ $user->getTimeSinceLastGame() }})</span>
                        @endif
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

