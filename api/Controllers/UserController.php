<?php
/**
 * Author: Course Project Team
 * Date: 6/15/2026
 * File: UserController.php
 * Description: Define the user controller class.
 */

namespace courseProj\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use courseProj\Controllers\ControllerHelper as Helper;
use courseProj\Models\User;

class UserController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        $results = User::getUsers();
        return Helper::withJson($response, $results, 200);
    }

    public function view(Request $request, Response $response, array $args): Response
    {
        $results = User::getUserById((int)$args['id']);
        return Helper::withJson($response, $results, 200);
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody() ?? [];
        $errors = $this->validateUser($params, true);

        if (!empty($errors)) {
            return Helper::withJson($response, ['status' => 'Validation failed', 'errors' => $errors], 400);
        }

        $user = User::createUser($request);

        return Helper::withJson($response, ['status' => 'User has been created.', 'data' => $user], 201);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $request = $request->withAttribute('id', $args['id']);
        $params = $request->getParsedBody() ?? [];
        $errors = $this->validateUser($params, false);

        if (!empty($errors)) {
            return Helper::withJson($response, ['status' => 'Validation failed', 'errors' => $errors], 400);
        }

        $user = User::updateUser($request);

        return Helper::withJson($response, ['status' => 'User has been updated.', 'data' => $user], 200);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $request = $request->withAttribute('id', $args['id']);
        User::deleteUser($request);

        return Helper::withJson($response, ['status' => 'User has been deleted.'], 200);
    }

    private function validateUser(array $params, bool $requirePassword): array
    {
        $errors = [];

        foreach (['name', 'email', 'username'] as $field) {
            if (empty($params[$field])) {
                $errors[$field] = ucfirst($field) . ' is required.';
            }
        }

        if (!empty($params['email']) && !filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'A valid email address is required.';
        }

        if ($requirePassword && empty($params['password'])) {
            $errors['password'] = 'Password is required.';
        }

        if (isset($params['role_id']) && !filter_var($params['role_id'], FILTER_VALIDATE_INT)) {
            $errors['role_id'] = 'Role id must be an integer.';
        }

        return $errors;
    }
}

