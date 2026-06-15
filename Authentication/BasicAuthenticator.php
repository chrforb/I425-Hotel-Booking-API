<?php
namespace courseProj\Authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use courseProj\Models\User;

class BasicAuthenticator
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // If the Authorization header does not exist
        if (!$request->hasHeader('Authorization')) {
            $results = ['Status' => 'Authorization header not found.'];
            return AuthenticationHelper::withJson($results, 401);
        }
       $auth = $request->getHeader('Authorization')[0];

       list(, $apikey) = explode(" ", $auth, 2);

      if (!User::authenticateUser($user, $password)) {

            $results = ['status' => 'Authentication failed'];

            $response = AuthenticationHelper::withJson($results, 403);

            return $response->withHeader(
                'WWW-Authenticate',
                'Basic realm="HotelBookingSystem API"'
            );
        }

      return $handler->handle($request);
    }
}


