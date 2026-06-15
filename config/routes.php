<?php
/**
 * Author: Christian Forbes and Course Project Team
 * Date: 6/15/2026
 * File: routes.php
 * Description: Defines application routes.
 */

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use courseProj\Authentication\MyAuthenticator;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write('Welcome to CourseProj Hotel Booking API!');
        return $response;
    });

    $app->get('/api/hello/{name}', function (Request $request, Response $response, array $args) {
        $response->getBody()->write('Hello ' . $args['name']);
        return $response;
    });

    $app->group('/api/v1/users', function (RouteCollectorProxy $group) {
        $group->get('', 'User:index');
        $group->get('/{id}', 'User:view');
        $group->post('', 'User:create');
        $group->put('/{id}', 'User:update');
        $group->delete('/{id}', 'User:delete');
    });

    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        $group->group('/guests', function (RouteCollectorProxy $group) {
            $group->get('', 'Guest:index');
            $group->get('/{id}', 'Guest:view');
            $group->get('/{id}/bookings', 'Guest:viewBookings');
        });

        $group->group('/rooms', function (RouteCollectorProxy $group) {
            $group->get('', 'Room:index');
            $group->get('/{id}', 'Room:view');
        });

        $group->group('/bookings', function (RouteCollectorProxy $group) {
            $group->get('', 'Booking:index');
            $group->get('/{id}', 'Booking:view');
        });
    })->add(new MyAuthenticator());
};
