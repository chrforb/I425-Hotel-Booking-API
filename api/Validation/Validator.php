<?php
/**
 * Author: Christian Forbes
 * Date: 6/8/2026
 * File: Validator.php
 * Description: defines validator
 */


namespace courseProj\Validation;

class Validator
{
    private static $errors = [];

    public static function getErrors()
    {
        return self::$errors;
    }

    public static function validateGuest($request)
    {
        self::$errors = [];

        $params = $request->getParsedBody();

        if (!isset($params['first_name']) || trim($params['first_name']) === '') {
            self::$errors['first_name'] = 'First name is required.';
        }

        if (!isset($params['last_name']) || trim($params['last_name']) === '') {
            self::$errors['last_name'] = 'Last name is required.';
        }

        if (!isset($params['email']) || !filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
            self::$errors['email'] = 'Valid email is required.';
        }

        return empty(self::$errors);
    }

    public static function validateRoom($request)
    {
        self::$errors = [];

        $params = $request->getParsedBody();

        if (!isset($params['hotel_id']) || !is_numeric($params['hotel_id'])) {
            self::$errors['hotel_id'] = 'Hotel ID is required and must be numeric.';
        }

        if (!isset($params['room_number']) || trim($params['room_number']) === '') {
            self::$errors['room_number'] = 'Room number is required.';
        }

        if (!isset($params['room_type']) || trim($params['room_type']) === '') {
            self::$errors['room_type'] = 'Room type is required.';
        }

        if (!isset($params['price_per_night']) || !is_numeric($params['price_per_night'])) {
            self::$errors['price_per_night'] = 'Price per night must be numeric.';
        }

        return empty(self::$errors);
    }
}