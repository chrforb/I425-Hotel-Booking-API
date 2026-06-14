<?php
/**
 * Author: Christian Forbes
 * Date: 5/31/2026
 * File: dependencies.php
 * Description:
 */

use DI\Container;
use courseProj\Controllers\{GuestController, };
use courseProj\Models\{Guest, Amenity, Booking, Hotel, Room};
use courseProj\Controllers\RoomController;
use courseProj\Controllers\BookingController;
use courseProj\Controllers\AmenityController;
use courseProj\Controllers\HotelController;
use courseProj\Controllers\UserController;
use courseProj\Authentication\JWTAuthenticator;

return function (Container $container) {

    $container->set('Guest', function () {
        return new GuestController();
    });

    $container->set('Room', function() {
        return new RoomController();
    });

    $container->set('Booking', function() {
        return new BookingController();
    });

   $container->set('Amenity', function () {
        return new AmenityController();
    });

    $container->set('Hotel', function () {
        return new HotelController();
   });

    $container->set('User', function () {
        return new UserController();
    });

};
