<?php

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    use Slim\Exception\NotFoundException;

    require 'vendor/autoload.php';
    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $app = AppFactory::create();
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    
    $wsVentasEndpoint = $_ENV['WS_VENTAS_ENDPOINT'];
    $wsAlmacenEndpoint = $_ENV['WS_ALMACEN_ENDPOINT'];
    $wsVentas = new SoapClient($wsVentasEndpoint);
    $wsAlmacen = new SoapClient($wsAlmacenEndpoint);

    $app->get('/getProd[/{categoria}]', function ( Request $request, Response $response, $args ) {
        global $wsVentas;
        $body = $request->getParsedBody();
        $result = $wsVentas->getProd(
            $body['user'],
            $body['pass'],
            $args['categoria'] 
        );
        $response->getBody()->write(json_encode($result));
        return $response;
    });

    $app->get('/getDetails[/{isbn}]', function ( Request $request, Response $response, $args ) {
        global $wsVentas;
        $body = $request->getParsedBody();
        $result = $wsVentas->getDetails(
            $body['user'],
            $body['pass'],
            $args['isbn'] 
        );
        $response->getBody()->write(json_encode($result));
        return $response;
    });

    $app->post('/setProd[/{categoria}]', function ( Request $request, Response $response, $args ){
        global $wsAlmacen;
        $body = $request->getParsedBody();
        $result = $wsAlmacen->setProd(array(
            'user' => $body['user'],
            'pass' => $body['pass'],
            'categoria' => $args['categoria'],
            'producto' => json_encode($body['producto'])));
        $response->getBody()->write(json_encode($result->setProdResult));
        return $response;
    });

    $app->put('/updateProd[/{isbn}]',function ( Request $request, Response $response, $args ) {
        global $wsAlmacen;
        $body = $request->getParsedBody();
        $result = $wsAlmacen->updateProd(array(
            'user' => $body['user'],
            'pass' => $body['pass'],
            'isbn' => $args['isbn'],
            'detalles' => json_encode($body['detalles'])));
        $response->getBody()->write(json_encode($result->updateProdResult));
        return $response;
    });

    $app->delete('/deleteProd[/{isbn}]', function ( Request $request, Response $response, $args ){
        global $wsAlmacen;
        $body = $request->getParsedBody();
        $result = $wsAlmacen->deleteProd(array(
            'user' => $body['user'],
            'pass' => $body['pass'],
            'isbn' => $args['isbn']));
        $response->getBody()->write(json_encode($result->deleteProdResult));
        return $response;
    });

    $app->run();
?>