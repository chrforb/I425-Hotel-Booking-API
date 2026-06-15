<?php
/**
 * Author: Christian Forbes
 * Date: 5/31/2026
 * File: routes.php
 * Description: defines application routes
 */

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

 use courseProj\Authentication\{
        MyAuthenticator,
        BasicAuthenticator,
        BearerAuthenticator
    };

return function (App $app) {

    // define app route
    $app->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write('Welcome to CourseProj Hotel Booking API!');
        return $response;
    });

    // test route
    $app->get('/api/hello/{name}', function (Request $request, Response $response, array $args) {
        $response->getBody()->write('Hello ' . $args['name']);
        return $response;
    });

    $app->group('/api/v1', function (RouteCollectorProxy $group) {

        $group->group('/guests', function (RouteCollectorProxy $group) {
            $group->get('', 'Guest:index');
            $group->get('/{id}', 'Guest:view');
        });
        
        $group->group('/rooms', function (RouteCollectorProxy $group) {
            $group->get('', 'Room:index');
            $group->get('/{id}', 'Room:view');
        });

        $group->group('/bookings', function (RouteCollectorProxy $group) {
            $group->get('', 'Booking:index');
            $group->get('/{id}', 'Booking:view');
        });
   $group->group('/guests', function (RouteCollectorProxy $group) { $group->get('', 'Guest:index'); $group->get('/{id}', 'Guest:view'); 
    };
        $app->group('/api/v1', function(RouteCollectorProxy $group) {

        })->add(new BasicAuthenticator());
        })->add(new BearerAuthenticator());
