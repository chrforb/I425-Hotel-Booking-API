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
        if (!$request->hasHeader('Authorization')) {
            return AuthenticationHelper::withJson(['Status' => 'Authorization header not found.'], 401)
                ->withHeader('WWW-Authenticate', 'Basic realm="HotelBookingSystem API"');
        }

        $auth = $request->getHeader('Authorization')[0];

        if (!str_starts_with($auth, 'Basic ')) {
            return AuthenticationHelper::withJson(['Status' => 'Basic authorization required.'], 401);
        }

        $encoded = substr($auth, 6);
        $decoded = base64_decode($encoded);

        if (!$decoded || !str_contains($decoded, ':')) {
            return AuthenticationHelper::withJson(['Status' => 'Invalid Basic authorization format.'], 400);
        }

        [$user, $password] = explode(':', $decoded, 2);

        if (!User::authenticateUser($user, $password)) {
            return AuthenticationHelper::withJson(['Status' => 'Authentication failed.'], 403)
                ->withHeader('WWW-Authenticate', 'Basic realm="HotelBookingSystem API"');
        }

        return $handler->handle($request);
    }
}