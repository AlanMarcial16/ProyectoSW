<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\NotFoundException;

require 'vendor/autoload.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$wsventasEndpoint = 'https://wsventas.azurewebsites.net/WSVentas.php?wsdl';
$wsventas = new SoapClient($wsventasEndpoint);
$wsalmacenEndpoint = 'https://wsalmacen-wcf.azurewebsites.net/WSAlmacen.svc?wsdl';
$wsalmacen = new SoapClient($wsalmacenEndpoint);

$app->get('/getProd[/{categoria}]', function ( Request $request, Response $response, $args ) {
global $wsventas;
$body = $request->getParsedBody();

$result = $wsventas->__soapCall('getProd', array(
    'user'=>$request["user"], 'pass'=>$request["pass"], 'categoria'=>$request["categoria"]));
    $json = array('code'=>$result->code, 'message'=>$result->message, 'data'=>$result->data, 'status'=>$result->status);
    $response->getBody()->write(var_dump($body));
return $response;
});

$app->put('/updateProd[/{isbn}]', function ( Request $request, Response $response, $args ) {
global $wsalmacen;
$body = $request->getParsedBody();
$response->getBody()->write($body);
/*$result = $wsalmacen->__soapCall('updateProd', array('user'=>$body["user"], 'pass'=>$body["pass"], 'detalles'=>$body["detalles"], 'isbn'=>$args["isbn"]));
    $json = array('code'=>$result->code, 'message'=>$result->message, 'data'=>$result->data, 'status'=>$result->status);
    $response->getBody()->write(json_encode($json));*/
});

$app->run();

?>