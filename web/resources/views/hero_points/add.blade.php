@extends('admin.layout')

@section('title')
Add Hero Points
@stop

@section('admin_content')
    <div class="info-panel">
        <h2>Modify Hero Points</h2>

        <form action="{{ URL::route('admin.hero_points.update') }}" method="POST" class="pure-form pure-form-aligned">
            {{ csrf_field() }}

            <div class="pure-control-group">
                <label for="user_id">User:</label>
                <select name="user_id" title="user_id">
                    @foreach($userList as $index => $option)
                        <option value="{{ $index }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>

            <p>
                <strong>Note:</strong> the amount to change points by is a difference. So if a user has 12 points and the user
                should have 15 points, you would enter "3" into this field.
            </p>

            <!-- Difference Form Input -->
            <div class="pure-control-group">
                <label for="difference">Change By:</label>
                <input type="number" name="difference" title="difference" value="0" />
            </div>

            <div class="pure-controls">
                <input type="submit" class="button success" value="Update" />
            </div>
        </form>
    </div>

    <script type="text/javascript">
        $('select[name="user_id"]').select2();
    </script>
@stop
