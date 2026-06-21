<?php
/**
 * Author: Christian Forbes
 * Date: 5/31/2026
 * File: GuestController.php
 * Description: defines the guest controller
 */

namespace courseProj\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use courseProj\Models\Guest;
use courseProj\Controllers\ControllerHelper as Helper;
use courseProj\Validation\Validator;

class GuestController {

    // retrieve all guests
    public function index(Request $request, Response $response, array $args)
    {
        $results = Guest::getGuests($request);

        return Helper::withJson($response, $results, 200);
    }

    // retrieve specific guest
    public function view(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $results = Guest::getGuestById($id);
        return Helper::withJson($response, $results, 200);
    }

    public function viewBookings(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $results = Guest::getBookingsByGuest($id);
        return Helper::withJson($response, $results, 200);
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        $validation = Validator::validateGuest($request);

        if (!$validation) {
            $results = [
                'status' => 'Validation failed',
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        $guest = Guest::createGuest($request);

        $results = [
            'status' => 'Guest has been created.',
            'data' => $guest
        ];

        return Helper::withJson($response, $results, 200);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $validation = Validator::validateGuest($request);

        if (!$validation) {
            $results = [
                'status' => 'Validation failed',
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        $guest = Guest::updateGuest($request);

        $results = [
            'status' => 'Guest has been updated.',
            'data' => $guest
        ];

        return Helper::withJson($response, $results, 200);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $guest = Guest::deleteGuest($request);

        $results = [
            'status' => 'Guest has been deleted.',
            'data' => $guest
        ];

        return Helper::withJson($response, $results, 200);
    }
}
