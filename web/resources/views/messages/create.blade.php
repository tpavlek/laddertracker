@extends('admin.layout')

@section('title')
    Create Message
@stop

@section('admin_content')
    <div class="info-panel">
        <h2>Create Message</h2>
        {!! Form::open([ 'route' => 'admin.messages.store', 'method' => 'POST', 'class' => 'pure-form pure-form-aligned' ]) !!}
        <div class="pure-control-group">
            {!! Form::label('message', "Message:") !!}
            {!! Form::textarea('message') !!}
        </div>

        <p>
            <strong>Note:</strong> messages by default expire at midnight on the day you select (start of day)
        </p>

        <div class="pure-control-group">
            {!! Form::label('expires', "Expires On:") !!}
            {!! Form::input('date', 'expires', \Carbon\Carbon::now()->addWeek()->toDateString()) !!}
        </div>

        <div class="pure-controls">
            <input type="submit" class="button success" value="Create" />
        </div>
        {!! Form::close() !!}
    </div>
@stop
