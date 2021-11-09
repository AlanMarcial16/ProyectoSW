<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\NotFoundException;

require 'vendor/autoload.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function ( Request $request, Response $response, $args ) {
$response->getBody()->write("Hola Mundo Slim!!");
return $response;
});

$app->get('/hola[/{nombre}]', function( Request $request, Response $response, $args ) {
    $response->getBody()->write("Hola ".$args["nombre"]);
    return $response;
});

$app->run();

?>