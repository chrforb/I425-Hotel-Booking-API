<?php
/**
 * Author: Christian Forbes
 * Date: 6/14/2026
 * File: UserController.php
 * Description: defines the user controller class
 */


namespace courseProj\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use courseProj\Controllers\ControllerHelper as Helper;
use courseProj\Models\User;

class UserController
{
    public function create(Request $request, Response $response, array $args): Response
    {
        $user = User::createUser($request);

        return Helper::withJson($response, [
            'status' => 'User has been created',
            'data' => $user
        ], 201);
    }

    public function authJWT(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody();

        $username = $params['username'] ?? '';
        $password = $params['password'] ?? '';

        $user = User::authenticateUser($username, $password);

        if (!$user) {
            return Helper::withJson($response, [
                'Status' => 'Login failed.'
            ], 401);
        }

        $jwt = User::generateJWT($user->id);

        return Helper::withJson($response, [
            'Status' => 'Login successful',
            'jwt' => $jwt,
            'name' => $user->name,
            'role' => $user->role
        ], 200);
    }
}