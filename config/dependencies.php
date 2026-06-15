<?php
/**
 * Author: Christian Forbes and Course Project Team
 * Date: 6/15/2026
 * File: dependencies.php
 * Description: Register controller dependencies.
 */

use DI\Container;
use courseProj\Controllers\GuestController;
use courseProj\Controllers\RoomController;
use courseProj\Controllers\BookingController;
use courseProj\Controllers\UserController;

return function (Container $container) {
    $container->set('Guest', function () {
        return new GuestController();
    });

    $container->set('Room', function () {
        return new RoomController();
    });

    $container->set('Booking', function () {
        return new BookingController();
    });

    $container->set('User', function () {
        return new UserController();
    });
};
