@extends('admin.layout')

@section('title')
    Expire Messages
@stop

@section('admin_content')
    <div class="info-panel">
        <h2>Expire All Messages</h2>
        {!! Form::open([ 'route' => 'admin.messages.finalize_expire', 'method' => 'POST', 'class' => 'pure-form pure-form-aligned' ]) !!}

        <p>
            Use this button to automatically expire the messsages in the database, so they will no longer show on the
            front page.
        </p>

        <div class="pure-controls">
            <input type="submit" class="button success" value="Expire" />
        </div>

        {!! Form::close() !!}
    </div>
@stop
