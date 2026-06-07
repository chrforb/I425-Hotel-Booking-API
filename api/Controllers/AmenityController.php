<?php
/**
 * Author: Christian Forbes
 * Date: 6/7/2026
 * File: AmenityController.php
 * Description: defines amenity controller class
 */

namespace courseProj\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use courseProj\Models\Amenity;
use courseProj\Controllers\ControllerHelper as Helper;

class AmenityController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        return Helper::withJson(
            $response,
            Amenity::getAmenities(),
            200
        );
    }

    public function view(Request $request, Response $response, array $args): Response
    {
        return Helper::withJson(
            $response,
            Amenity::getAmenityById($args['id']),
            200
        );
    }

    public function viewBookings(Request $request, Response $response, array $args): Response
    {
        return Helper::withJson(
            $response,
            Amenity::getBookingsByAmenity($args['id']),
            200
        );
    }
}