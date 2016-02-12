<html>
<head>
    <title>@yield('title', "") - NA Ladder Heroes</title>
    <link rel="stylesheet" type="text/css" href="/css/all.css" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
</head>
<body>
<nav class="nav-header">
    <span class="title"><a href="/">Ladder Heroes</a></span>
    <ul>
        <li><a href="{{ URL::route('home.standings') }}">Standings</a></li>
        <li><a href="{{ URL::route('home.about') }}">Signup</a></li>
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
