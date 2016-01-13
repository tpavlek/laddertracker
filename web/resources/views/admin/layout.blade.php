@extends('layout')

@section('content')
    <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-4">
            <nav class="sidebar">
                <h3>User</h3>
                <ul>
                    <li>
                        <a href="{{ URL::route('admin.user.list') }}">List</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('admin.user.create') }}">Register</a>
                    </li>

                </ul>

                <hr />

                <h3>Ladder</h3>
                <ul>
                    <li>
                        <a href="{{ URL::route('admin.ladder.update') }}">Manual Update</a>
                    </li>
                </ul>

                <hr/>

                <h3>Hero Points</h3>
                <ul>
                    <li>
                        <a href="{{ URL::route('admin.hero_points.add') }}">Manual Addition</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('admin.hero_points.award') }}">Award</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('admin.hero_points.end_month') }}">End Month</a>
                    </li>
                </ul>

                <hr />

                <h3>Messages</h3>
                <ul>
                    <li>
                        <a href="{{ URL::route('admin.messages.create') }}">Create</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('admin.messages.expire') }}">Expire</a>
                    </li>
                </ul>

            </nav>
        </div>
        <div class="pure-u-1 pure-u-md-3-4">
            @yield('admin_content')
        </div>
    </div>


@stop
