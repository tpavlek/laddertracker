<?php

require '../bootstrap.php';

$router = new \League\Route\RouteCollection;

$router->addRoute('GET', '/', function(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\HttpFoundation\Response $response) {

    $response->setContent("Weow");
    return $response;
});

$dispatcher = $router->getDispatcher();

$response = $dispatcher->dispatch('GET', '/');
$response->send();
