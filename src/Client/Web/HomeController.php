<?php

namespace Depotwarehouse\LadderTracker\Client\Web;

use Depotwarehouse\LadderTracker\Database\User\UserRepository;

class HomeController
{

    protected $userRepository;
    /** @var \Twig_Environment  */
    protected $twig;

    public function __construct(UserRepository $userRepository, \Twig_Environment $twig)
    {
        $this->userRepository = $userRepository;
        $this->twig = $twig;
    }

    public function home()
    {
        $users = $this->userRepository->top(20);

        return $this->twig->render('home.html.twig', [ 'users' => $users ]);
    }

    public function about()
    {
        return $this->twig->render('about.html.twig');
    }
}
