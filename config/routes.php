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
use courseProj\Authentication\JWTAuthenticator;

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
            $group->get('/{id}/bookings', 'Guest:viewBookings');
            $group->post('', 'Guest:create');
            $group->put('/{id}', 'Guest:update');
            $group->delete('/{id}', 'Guest:delete');
        });
        
        $group->group('/rooms', function (RouteCollectorProxy $group) {
            $group->get('', 'Room:index');
            $group->get('/{id}', 'Room:view');
            $group->get('/{id}/bookings', 'Room:viewBookings');
            $group->post('', 'Room:create');
            $group->put('/{id}', 'Room:update');
            $group->delete('/{id}', 'Room:delete');
        });

        $group->group('/bookings', function (RouteCollectorProxy $group) {
            $group->get('', 'Booking:index');
            $group->get('/{id}', 'Booking:view');
            $group->get('/{id}/amenities', 'Booking:viewAmenities');
        });

        $group->group('/hotels', function (RouteCollectorProxy $group) {
            $group->get('', 'Hotel:index');
            $group->get('/{id}', 'Hotel:view');
            $group->get('/{id}/rooms', 'Hotel:viewRooms');
        });

        $group->group('/amenities', function (RouteCollectorProxy $group) {
            $group->get('', 'Amenity:index');
            $group->get('/{id}', 'Amenity:view');
            $group->get('/{id}/bookings', 'Amenity:viewBookings');
        });

        $group->group('/users', function (RouteCollectorProxy $group) {
            $group->post('', 'User:create');
            $group->post('/authJWT', 'User:authJWT');
            $group->post('/validateJWT', 'User:validateJWT');
        });

        $group->group('/jwt-protected', function (RouteCollectorProxy $group) {
            $group->get('/guests', 'Guest:index');
        })->add(new JWTAuthenticator());

    });
};
