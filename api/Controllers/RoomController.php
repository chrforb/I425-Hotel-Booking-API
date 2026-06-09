<?php

namespace courseProj\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use courseProj\Models\Room;
use courseProj\Controllers\ControllerHelper as Helper;

class RoomController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        $results = Room::getRooms();
        return Helper::withJson($response, $results, 200);
    }

    public function view(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $results = Room::getRoomById($id);
        return Helper::withJson($response, $results, 200);
    }

     public function delete($request, $response, $args)
{
        $room = Room::find($args['id']);

        if (!$room) {
            return $response->withJson([
                "message" => "Room not found"
            ], 404);
        }

        $room->delete();

        return $response->withJson([
            "message" => "Room deleted successfully"
        ], 200);
    }

    public function search($request, $response, $args)
    {
        $search = $request->getQueryParam('search');

        $keywords = explode(' ', $search);

        $rooms = Room::search($keywords);

        return $response->withJson($rooms, 200);
    }
}
