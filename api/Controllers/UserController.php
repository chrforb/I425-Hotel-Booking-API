<?php
use courseProj\Models\Token;

public function authBearer(Request $request, Response $response, array $args): Response
{
    // Retrieve username and password
    $params = $request->getParsedBody();

    $username = $params['username'];
    $password = $params['password'];

    // Verify username and password
    $user = User::authenticateUser($username, $password);

    if (!$user) {
        return Helper::withJson(
            $response,
            ['Status' => 'Login failed.'],
            401
        );
    }

    // Generate token
    $token = Token::generateBearer($user->id);

    $results = [
        'Status' => 'Login successful',
        'Token' => $token
    ];

    return Helper::withJson($response, $results, 200);
}
