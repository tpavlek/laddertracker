@extends('admin.layout')

@section('title')
    Create Message
@stop

@section('admin_content')
    <div class="info-panel">
        <h2>Create Message</h2>
        <form action="{{ URL::route('admin.messages.store') }}" method="POST" class="pure-form pure-form-aligned">
            {{ csrf_field() }}

            <!-- Message Form Input -->
            <div class="pure-control-group">
                <label for="message">Message</label>
                <textarea name="message" title="message"></textarea>
            </div>

            <p>
                <strong>Note:</strong> messages by default expire at midnight on the day you select (start of day)
            </p>

            <div class="pure-control-group">
                <label for="expires">Expires On:</label>
                <input type="date" name="expires" title="expires" value="{{ \Carbon\Carbon::now()->addWeek()->toDateString() }}" />
            </div>

            <div class="pure-controls">
                <input type="submit" class="button success" value="Create" />
            </div>

        </form>
    </div>
@stop
