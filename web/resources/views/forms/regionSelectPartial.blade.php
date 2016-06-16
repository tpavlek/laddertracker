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
