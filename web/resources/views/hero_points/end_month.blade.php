@extends('admin.layout')

@section('title')
End Month
@stop

@section('admin_content')
    <div class="info-panel">
        <h2>End Month</h2>
        <form action="{{ URL::route('admin.hero_points.finalize_month') }}" method="POST" class="pure-form pure-form-aligned">
            {{ csrf_field() }}

            <p>
                Use this button to end the current ladder heroes month.
            </p>

            <p>
                This will have two effects, it will store the current results in the History section, and it will reset all
                the Hero Points of all participants to zero.
            </p>

            <!-- Region Form Input -->
            <div class="pure-control-group">
                <label for="region">Region</label>
                <select name="region" title="region">
                    <option value="{{ \Depotwarehouse\LadderTracker\ValueObjects\Region::america()->toString() }}">
                        {{ \Depotwarehouse\LadderTracker\ValueObjects\Region::america()->niceString() }}
                    </option>

                    <option value="{{ \Depotwarehouse\LadderTracker\ValueObjects\Region::europe()->toString() }}">
                        {{ \Depotwarehouse\LadderTracker\ValueObjects\Region::europe()->niceString() }}
                    </option>
                </select>
            </div>

            <div class="pure-controls">
                <input type="submit" class="button success" value="End Month" />
            </div>

        </form>
    </div>
@stop
