<?php

namespace courseProj\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use courseProj\Models\Room;
use courseProj\Controllers\ControllerHelper as Helper;
use courseProj\Validation\Validator;

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

    public function create(Request $request, Response $response, array $args): Response
    {
        $validation = Validator::validateRoom($request);

        if (!$validation) {
            $results = [
                'status' => 'Validation failed',
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        $room = Room::createRoom($request);

        $results = [
            'status' => 'Room has been created.',
            'data' => $room
        ];

        return Helper::withJson($response, $results, 200);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $validation = Validator::validateRoom($request);

        if (!$validation) {
            $results = [
                'status' => 'Validation failed',
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        $room = Room::updateRoom($request);

        $results = [
            'status' => 'Room has been updated.',
            'data' => $room
        ];

        return Helper::withJson($response, $results, 200);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $room = Room::deleteRoom($request);

        $results = [
            'status' => 'Room has been deleted.',
            'data' => $room
        ];

        return Helper::withJson($response, $results, 200);
    }
}
