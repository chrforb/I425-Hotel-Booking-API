<?php
/**
 * Author: Christian Forbes
 * Date: 6/7/2026
 * File: HotelController.php
 * Description: defines hotel controller class
 */


namespace courseProj\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use courseProj\Models\Hotel;
use courseProj\Controllers\ControllerHelper as Helper;

class HotelController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        return Helper::withJson($response, Hotel::getHotels(), 200);
    }

    public function view(Request $request, Response $response, array $args): Response
    {
        return Helper::withJson($response, Hotel::getHotelById($args['id']), 200);
    }

    public function viewRooms(Request $request, Response $response, array $args): Response
    {
        return Helper::withJson($response, Hotel::getRoomsByHotel($args['id']), 200);
    }
}