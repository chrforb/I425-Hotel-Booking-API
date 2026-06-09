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
    public function delete($request, $response, $args)
    {
        $booking = Booking::find($args['id']);

        if (!$booking) {
            return $response->withJson([
                "message" => "Booking not found"
            ], 404);
        }

        $booking->delete();

        return $response->withJson([
            "message" => "Booking deleted successfully"
        ], 200);
    }
    public function search($request, $response, $args)
    {
        $search = $request->getQueryParam('search');

        $keywords = explode(' ', $search);

        $bookings = Booking::search($keywords);

        return $response->withJson($bookings, 200);
    }
}
