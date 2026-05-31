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

class GuestController {

    // retrieve all guests
    public function index(Request $request, Response $response, array $args) {
        $results = Guest::getGuests();
        return Helper::withJson($response, $results, 200);
    }

    // retrieve specific guest
    public function view(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $results = Guest::getGuestById($id);
        return Helper::withJson($response, $results, 200);
    }
}