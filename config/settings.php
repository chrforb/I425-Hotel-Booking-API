<?php
/**
 * Author: Christian Forbes
 * Date: 5/31/2026
 * File: settings.php
 * Description:
 */

// Should be set to 0 in production
error_reporting(E_ALL);

// Should be set to '0' in production
ini_set('display_errors', '1');

// Timezone
date_default_timezone_set('America/New_York');

// Create an anonymous function that sets settings in the container
// The parameter of the function is a Container object
return function (DI\Container $container) {
    $container->set('settings', function () {
        return [
            /*
             * set base path to course folder. my directory is C:\Users\chris\I425\courseProj. if you named it different
             * just change the database name in db array. you'll have to make sure your postman db value also
             * matches the path you use
            */
            'basePath' => '/I425/courseProj',

            //database settings
            'db' => [
                'driver' => "mysql",
                'host' => 'localhost',
                'database' => 'hotel_booking_system',
                'username' => 'phpuser',
                'password' => 'phpuser',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => ''
            ]
        ];
    });
};