<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Http\Controllers;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

}
