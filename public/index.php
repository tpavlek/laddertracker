<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require '../bootstrap.php';

$loader = new Twig_Loader_Filesystem('../resources/views');
$twig = new Twig_Environment($loader);

$router = new \League\Route\RouteCollection;

$handler = new \Illuminate\Session\CookieSessionHandler(new \Illuminate\Cookie\CookieJar(), 3600);
$session = new \Illuminate\Session\Store("trackersession", $handler);
$auth = new \Illuminate\Auth\Guard(new \Depotwarehouse\LadderTracker\Client\Web\Auth\UserProvider(), $session);


$controller = new \Depotwarehouse\LadderTracker\Client\Web\HomeController(
    new \Depotwarehouse\LadderTracker\Database\User\UserRepository($capsule->getConnection(), new \Depotwarehouse\LadderTracker\Database\User\UserConstructor()),
    $twig
);

$router->addRoute('GET', '/', function(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\HttpFoundation\Response $response) use ($controller) {
    $content = $controller->home();

    $response->setContent($content);
    return $response;
});

$router->addRoute('GET', '/about', function (Request $request, \Symfony\Component\HttpFoundation\Response $response) use ($controller) {
    $content = $controller->about();

    $response->setContent($content);
    return $response;
});

$router->addRoute('GET', '/secure/admin', function (Request $request, \Symfony\Component\HttpFoundation\Response $response) use ($auth, $twig) {
    $adminController = new \Depotwarehouse\LadderTracker\Client\Web\AdminController($auth, $twig);

    $response->setContent("security");
    return $response;
});

$router->addRoute('GET', '/secure', function (Request $request, \Symfony\Component\HttpFoundation\Response $response) use ($auth, $twig) {
    $adminController = new \Depotwarehouse\LadderTracker\Client\Web\AdminController($auth, $twig);

    $response->setContent($adminController->login());
    return $response;
});

$router->addRoute('GET', '/logout', function (Request $request, \Symfony\Component\HttpFoundation\Response $response) use ($auth, $twig) {
    $adminController = new \Depotwarehouse\LadderTracker\Client\Web\AdminController($auth, $twig);

    $response->setContent($adminController->logout());
    return $response;
});

$router->addRoute('POST', '/secure', function (Request $request, Response $response) use ($auth, $twig) {
    $adminController = new \Depotwarehouse\LadderTracker\Client\Web\AdminController($auth, $twig);

    $response->setContent($adminController->auth());
    return $response;
});

$dispatcher = $router->getDispatcher();

$request = Request::createFromGlobals();

try {
    $response = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
    $response->send();
} catch (\Exception $exception) {
    $response = new \Symfony\Component\HttpFoundation\Response();
    $response->setContent($exception->getMessage());
    $response->send();
}




