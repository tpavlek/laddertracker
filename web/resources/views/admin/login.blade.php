@extends('layout')

@section('title')
    Log In
@stop

@section('content')

<div class="welcome-splash">
    {!! Form::open([ 'route' => 'auth', 'method' => 'POST', 'class' => 'pure-form' ]) !!}
        <div class="pure-control-group">
            <label for="password">Password: </label>
            <input type="password" name="password" />
        </div>

        <div class="pure-controls">
            <input type="submit" value="Log in" class="button" />
        </div>
    {!! Form::close() !!}
</div>
@stop
