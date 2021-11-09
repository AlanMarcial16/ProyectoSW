<?php

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    use Slim\Exception\NotFoundException;

    require 'vendor/autoload.php';
    require_once 'WSVentas.php';
	require_once 'WSAlmacen.php';
    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $app = AppFactory::create();
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    
    $wsVentasEndpoint = $_ENV['WS_VENTAS_ENDPOINT'];
    $wsAlmacenEndpoint = $_ENV['WS_ALMACEN_ENDPOINT'];
    $wsVentas = new WSVentas($wsVentasEndpoint);
    $wsAlmacen = new WSAlmacen($wsAlmacenEndpoint);

	//RECEIVE REQUEST ONLY WITH Content-Type: application/json

    $app->get('/getProd[/{categoria}]', function ( Request $request, Response $response, $args ) {
        global $wsVentas;
        $body = $request->getParsedBody();
        $result = $wsVentas->getProd( $body['user'], $body['pass'], $args['categoria'] );
        $response->getBody()->write($result);
        return $response;
    });

    $app->get('/getDetails[/{isbn}]', function ( Request $request, Response $response, $args ){
        global $wsVentas;
        $body = $request->getParsedBody();
        $result = $wsVentas->getDetails($body['user'], $body['pass'], $args['isbn']);
        $response->getBody()->write($result);
        return $response;
    });

    $app->put('/updateProd[/{isbn}]',function ( Request $request, Response $response, $args ) {
        global $wsAlmacen;
        $body = $request->getParsedBody();
		$result = $wsAlmacen->updateProd($body['user'], $body['pass'], $args['isbn'], $body["detalles"]);
        $response->getBody()->write($result);
        return $response;
    });

    $app->put('/setProd[/{isbn}]', function ( Request $request, Response $response, $args ){
        global $wsAlmacen;
        $body = $request->getParsedBody();
        $result = $wsAlmacen->setProd($body['user'], $body['pass'], $args['isbn'], $body["detalles"]);
        $response->getBody()->write($result);
        return $response;

    });

    $app->delete('/deleteProd[/{isbn}]', function ( Request $request, Response $response, $args ){
        global $wsAlmacen;
        $body = $request->getParsedBody();
        $result = $wsAlmacen->deleteProd($body['user'], $body['pass'], $args['isbn']);
        $response->getBody()->write($result);
        return $response;
    });


    $app->run();
?>