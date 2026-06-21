<?php
/**
 * Author: Christian Forbes
 * Date: 6/14/2026
 * File: AuthenticationHelper.php
 * Description: defines the authentication helper class
 */


namespace courseProj\Authentication;

use Slim\Psr7\Response;

class AuthenticationHelper
{
    public static function withJson($data, int $code): Response
    {
        $response = new Response();

        $response->getBody()->write(
            json_encode($data)
        );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}