@extends('admin.layout')

@section('title')
Register User
@stop

@section('admin_content')
    <div class="info-panel">
        {!! Form::open([ 'route' => 'admin.user.register', 'method' => 'POST', 'class' => 'pure-form pure-form-aligned' ]) !!}
            <div class="pure-control-group">
                {!! Form::label('display_name', "Display Name:") !!}
                {!! Form::text('display_name') !!}
            </div>

            <div class="pure-control-group">
                {!! Form::label('bnet_url', "Battle.net URL:") !!}
                {!! Form::text('bnet_url') !!}
            </div>

            <div class="pure-controls">
                <input type="submit" class="button success" value="Register" />
            </div>

        {!! Form::close() !!}
    </div>
@stop
