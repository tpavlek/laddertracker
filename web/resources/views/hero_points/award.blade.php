@extends('admin.layout')

@section('title')
Award Hero Points
@stop

@section('admin_content')
    <div class="info-panel">
        <h2>Award Hero Points</h2>
        {!! Form::open([ 'route' => 'admin.hero_points.update_all', 'method' => 'POST', 'class' => 'pure-form pure-form-aligned' ]) !!}

        <p>
            Use this button to automatically award hero points to the top 16 players, based on their ladder ranking.
        </p>

        <div class="pure-controls">
            <input type="submit" class="button success" value="Award Points" />
        </div>

        {!! Form::close() !!}
    </div>
@stop
