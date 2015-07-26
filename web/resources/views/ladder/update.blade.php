@extends('admin.layout')

@section('title')
    Manually Update Standings
@stop

@section('admin_content')
    <div class="info-panel">
        <h2>Manual Battle.net Update</h2>
        {!! Form::open([ 'route' => 'admin.ladder.resync', 'method' => 'POST', 'class' => 'pure-form pure-form-aligned' ]) !!}

            <p>
                Use this button to make a call to the Battle.net API and update all the scores of the users.
            </p>
            <p>
                Bear in mind, that this is automatically run on a schedule, every minute, so only do this if you want an update <strong>now</strong>
            </p>
        <div class="pure-controls">
            <input type="submit" class="button success" value="Update Ranks" />
        </div>

        {!! Form::close() !!}
    </div>
@stop
