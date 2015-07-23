<?php

use Symfony\Component\HttpFoundation\Request;

require '../bootstrap.php';

$loader = new Twig_Loader_Filesystem('../resources/views');
$twig = new Twig_Environment($loader);

$router = new \League\Route\RouteCollection;

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




