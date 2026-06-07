<?php

namespace courseProj\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use courseProj\Models\Room;
use courseProj\Controllers\ControllerHelper as Helper;

class RoomController
{
    public function index(Request $request, Response $response, array $args) {
        $results = Room::getRooms($request);
        return Helper::withJson($response, $results, 200);
    }

    public function view(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $results = Room::getRoomById($id);
        return Helper::withJson($response, $results, 200);
    }

    public function viewBookings(Request $request, Response $response, array $args): Response {
        $id = (int)$args['id'];

        $results = Room::getBookingsByRoom($id);

        return Helper::withJson($response, $results, 200);
    }
}
