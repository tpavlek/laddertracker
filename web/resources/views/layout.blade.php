<html>
<head>
    <title>@yield('title', "") - NA Ladder Heroes</title>
    <link rel="stylesheet" type="text/css" href="/css/all.css" />
</head>
<body>
<nav class="nav-header">
    <span class="title"><a href="/">Ladder Heroes</a></span>
    <ul>
        <li><a href="{{ URL::route('home.standings') }}">Standings</a></li>
        <li><a href="{{ URL::route('home.about') }}">Rules</a></li>
        <li><a href="{{ URL::route('home.history') }}">History</a></li>

        @if (Auth::check())
            <li><a href="{{ URL::route('admin.index') }}">Admin</a></li>
            <li><a href="{{ URL::route('logout') }}">Logout</a></li>
        @endif
    </ul>
</nav>
@include('vendor.toolbox.errors.errorPartial')
@yield('content')
</body>
</html>
