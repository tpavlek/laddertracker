<?php

namespace Depotwarehouse\LadderTracker\Client\Web;

use Depotwarehouse\LadderTracker\Client\Web\Auth\User;
use Depotwarehouse\LadderTracker\Client\Web\Auth\UserProvider;
use Illuminate\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;

class AdminController
{

    protected $auth;

    public function __construct(Guard $auth, \Twig_Environment $twig)
    {
        $this->auth = $auth;
        $this->twig = $twig;
    }

    public function login()
    {
        if ($this->auth->check()) {
            return new RedirectResponse('/secure/admin');
        }
        return $this->twig->render('login.html.twig');
    }

    public function logout()
    {
        $this->auth->logout();
        return new RedirectResponse('/');
    }

    public function auth()
    {
        $input = Request::createFromGlobals();

        if ($input->get('password') === "ravioli") {
            $this->auth->login(new User());
            return new RedirectResponse('/');
        }
    }
}
