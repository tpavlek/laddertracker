<?php

namespace Depotwarehouse\LadderTracker\Client\Web\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function login()
    {
        //dd($this->auth->check());
        return view('admin.login');
    }

    public function auth(Request $input)
    {
        if (!$input->has('password') || $input->get('password') !== getenv('ADMIN_AUTH_PASSWORD')) {
            return redirect()->route('login')
                ->withErrors(new MessageBag([
                    'errors' => "Unable to authenticate (incorrect password?)"
                ]));
        }

        $this->auth->loginUsingId(1);
        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect()->route('home.index');
    }


}
