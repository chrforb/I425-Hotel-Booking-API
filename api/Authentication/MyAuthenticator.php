<?php
/**
 * Author: Course Project Team
 * Date: 6/15/2026
 * File: MyAuthenticator.php
 * Description: Custom header authenticator for the Hotel Booking API.
 */

namespace courseProj\Authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use courseProj\Models\User;

class MyAuthenticator
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (!$request->hasHeader('HotelBooking-Authorization')) {
            return AuthenticationHelper::withJson(
                ['Status' => 'HotelBooking-Authorization header not found.'],
                401
            );
        }

        $auth = $request->getHeader('HotelBooking-Authorization')[0];
        $credentials = explode(':', $auth, 2);

        if (count($credentials) !== 2) {
            return AuthenticationHelper::withJson(
                ['Status' => 'Invalid authorization header format. Use username:password.'],
                400
            );
        }

        [$username, $password] = $credentials;

        if (!User::authenticateUser($username, $password)) {
            return AuthenticationHelper::withJson(['Status' => 'Authentication failed.'], 403);
        }

        return $handler->handle($request);
    }
}
