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
            $group->get('/{id}/bookings', 'Guest:viewBookings'); // inside guests
        });
        
        $group->group('/rooms', function (RouteCollectorProxy $group) {
            $group->get('', 'Room:index');
            $group->get('/{id}', 'Room:view');
            $group->get('/{id}/bookings', 'Room:viewBookings');  // inside rooms
        });

        $group->group('/bookings', function (RouteCollectorProxy $group) {
            $group->get('', 'Booking:index');
            $group->get('/{id}', 'Booking:view');
            $group->get('/{id}/amenities', 'Booking:viewAmenities'); // inside bookings
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

    });
};
