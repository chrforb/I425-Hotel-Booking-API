<?php

namespace courseProj\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use courseProj\Models\Booking;
use courseProj\Controllers\ControllerHelper as Helper;

class BookingController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        $results = Booking::getBookings();
        return Helper::withJson($response, $results, 200);
    }

    public function view(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $results = Booking::getBookingById($id);
        return Helper::withJson($response, $results, 200);
    }

    public function viewAmenities(Request $request, Response $response, array $args): Response {
        $id = (int)$args['id'];

        $results = Booking::getAmenitiesByBooking($id);

        return Helper::withJson($response, $results, 200);
    }
}
