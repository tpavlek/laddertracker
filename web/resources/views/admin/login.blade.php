@extends('layout')

@section('title')
    Log In
@stop

@section('content')

<div class="welcome-splash">
    <form action="{{ URL::route('auth') }}" method="POST" class="pure-form">
        {{ csrf_field() }}

        <!-- Password Form Input -->
        <div class="pure-control-group">
            <label for="password">Password:</label>
            <input type="password" name="password" title="password"/>
        </div>

        <div class="pure-controls">
            <input type="submit" value="Log in" class="button" />
        </div>
    </form>
</div>
@stop
