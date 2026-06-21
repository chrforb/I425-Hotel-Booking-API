<?php
/**
 * Author: Christian Forbes
 * Date: 6/14/2026
 * File: UserController.php
 * Description: Defines the user controller class.
 */

namespace courseProj\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use courseProj\Controllers\ControllerHelper as Helper;
use courseProj\Models\User;
use courseProj\Models\Token;

class UserController
{
    public function create(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody() ?? [];

        foreach (['name', 'email', 'username', 'password'] as $field) {
            if (empty($params[$field])) {
                return Helper::withJson($response, [
                    'status' => 'Validation failed',
                    'error' => $field . ' is required'
                ], 400);
            }
        }

        $user = User::createUser($request);

        return Helper::withJson($response, [
            'status' => 'User has been created',
            'data' => $user
        ], 201);
    }

    public function authJWT(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody() ?? [];

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

    public function validateJWT(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody() ?? [];
        $token = $params['jwt'] ?? '';

        if (!$token && $request->hasHeader('Authorization')) {
            $auth = $request->getHeaderLine('Authorization');
            if (str_starts_with($auth, 'Bearer ')) {
                $token = substr($auth, 7);
            }
        }

        if (!$token) {
            return Helper::withJson($response, [
                'Status' => 'JWT token is required.'
            ], 400);
        }

        try {
            $decoded = User::validateJWT($token);

            return Helper::withJson($response, [
                'Status' => 'JWT is valid.',
                'data' => $decoded
            ], 200);
        } catch (\Exception $e) {
            return Helper::withJson($response, [
                'Status' => 'JWT is invalid.'
            ], 403);
        }
    }

    public function authBearer(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody() ?? [];

        $username = $params['username'] ?? '';
        $password = $params['password'] ?? '';

        $user = User::authenticateUser($username, $password);

        if (!$user) {
            return Helper::withJson($response, [
                'Status' => 'Login failed.'
            ], 401);
        }

        $token = Token::generateBearer($user->id);

        return Helper::withJson($response, [
            'Status' => 'Bearer token generated.',
            'token' => $token,
            'name' => $user->name,
            'role' => $user->role
        ], 200);
    }
}
