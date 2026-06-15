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
        // Authorization header missing
        if (!$request->hasHeader('Authorization')) {

            $results = ['Status' => 'Authorization header not found.'];

            return AuthenticationHelper::withJson($results, 401);
        }

        // Retrieve Authorization header
        $auth = $request->getHeader('Authorization')[0];

        // Remove "Bearer "
        list(, $token) = explode(" ", $auth, 2);

        // Validate token
        if (!Token::validateBearer($token)) {

            return AuthenticationHelper::withJson(
                ['Status' => 'Invalid token.'],
                403
            );
        }

        // Authentication succeeded
        return $handler->handle($request);
    }
}
