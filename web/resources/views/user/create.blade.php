@extends('admin.layout')

@section('title')
Register User
@stop

@section('admin_content')
    <div class="info-panel">
        <form action="{{ URL::route('admin.user.register') }}" method="POST" class="pure-form pure-form-aligned">
            {{ csrf_field() }}
            <!-- Display_name Form Input -->
            <div class="pure-control-group">
                <label for="display_name">Display Name:</label>
                <input type="text" name="display_name" title="display_name"/>
            </div>

            <!-- Bnet_url Form Input -->
            <div class="pure-control-group">
                <label for="bnet_url">Battle.net URL:</label>
                <input type="text" name="bnet_url" title="bnet_url"/>
            </div>

            <div class="pure-control-group">
                <label for="region">Region:</label>
                <select name="region">
                    <option value="{{ \Depotwarehouse\BattleNetSC2Api\Region::America }}">North America</option>
                    <option value="{{ \Depotwarehouse\BattleNetSC2Api\Region::Europe }}">Europe</option>
                </select>
            </div>

            <div class="pure-control-group">
                <label for="paypal">Paypal:</label>
                <input type="text" name="paypal" title="paypal"/>
            </div>

            <div class="pure-controls">
                <input type="submit" class="button success" value="Register" />
            </div>

        </form>
    </div>
@stop
