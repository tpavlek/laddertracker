@extends('admin.layout')

@section('title')
Add Hero Points
@stop

@section('admin_content')
    <div class="info-panel">
        <h2>Modify Hero Points</h2>
        {!! Form::open([ 'route' => 'admin.hero_points.update', 'method' => 'POST', 'class' => 'pure-form pure-form-aligned' ]) !!}
            <div class="pure-control-group">
                {!! Form::label('user_id', "User:") !!}
                {!! Form::select('user_id', $userList) !!}
            </div>

            <p>
                <strong>Note:</strong> the amount to change points by is a difference. So if a user has 12 points and the user
                should have 15 points, you would enter "3" into this field.
            </p>

            <div class="pure-control-group">
                {!! Form::label('difference', "Change By:") !!}
                {!! Form::input('number', 'difference', 0) !!}
            </div>

            <div class="pure-controls">
                <input type="submit" class="button success" value="Update" />
            </div>
        {!! Form::close() !!}
    </div>
@stop
