<?php
/**
 * Author: Christian Forbes
 * Date: 6/14/2026
 * File: JWTAuthenticator.php
 * Description: defines JWT Authenticator class
 */

namespace courseProj\Authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use courseProj\Models\User;

class JWTAuthenticator
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (!$request->hasHeader('Authorization')) {
            return AuthenticationHelper::withJson([
                'Status' => 'Authorization header not available'
            ], 401);
        }

        $auth = $request->getHeaderLine('Authorization');

        if (!str_starts_with($auth, 'Bearer ')) {
            return AuthenticationHelper::withJson([
                'Status' => 'Bearer token required'
            ], 401);
        }

        $token = substr($auth, 7);

        try {
            User::validateJWT($token);
        } catch (\Exception $e) {
            return AuthenticationHelper::withJson([
                'Status' => 'Authentication failed.'
            ], 403);
        }

        return $handler->handle($request);
    }
}