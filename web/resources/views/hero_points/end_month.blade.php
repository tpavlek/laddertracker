@extends('admin.layout')

@section('title')
End Month
@stop

@section('admin_content')
    <div class="info-panel">
        <h2>End Month</h2>
        {!! Form::open([ 'route' => 'admin.hero_points.finalize_month', 'method' => 'POST', 'class' => 'pure-form pure-form-aligned' ]) !!}

            <p>
                Use this button to end the current ladder heroes month.
            </p>

            <p>
                This will have two effects, it will store the current results in the History section, and it will reset all
                the Hero Points of all participants to zero.
            </p>

            <div class="pure-controls">
                <input type="submit" class="button success" value="End Month" />
            </div>

        {!! Form::close() !!}
    </div>
@stop
