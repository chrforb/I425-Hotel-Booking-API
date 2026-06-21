<?php

namespace courseProj\Authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use courseProj\Models\Token;

class BearerAuthenticator
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (!$request->hasHeader('Authorization')) {
            return AuthenticationHelper::withJson(['Status' => 'Authorization header not found.'], 401);
        }

        $auth = $request->getHeaderLine('Authorization');

        if (!str_starts_with($auth, 'Bearer ')) {
            return AuthenticationHelper::withJson(['Status' => 'Bearer token required.'], 401);
        }

        $token = substr($auth, 7);

        if (!Token::validateBearer($token)) {
            return AuthenticationHelper::withJson(['Status' => 'Invalid token.'], 403);
        }

        return $handler->handle($request);
    }
}
