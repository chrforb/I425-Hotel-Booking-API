<?php
/**
 * Author: Course Project Team
 * Date: 6/15/2026
 * File: AuthenticationHelper.php
 * Description: Helper class for authentication JSON responses.
 */

namespace courseProj\Authentication;

use Slim\Psr7\Response;

class AuthenticationHelper
{
    public static function withJson($data, int $code): Response
    {
        $response = new Response();
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}
