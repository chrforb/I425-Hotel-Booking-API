<?php
/**
 * Author: Course Project Team
 * Date: 6/15/2026
 * File: User.php
 * Description: Defines the User model class and authentication helper methods.
 */

namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role'
    ];

    protected $hidden = [
        'password'
    ];

    public static function getUsers()
    {
        return self::all();
    }

    public static function getUserById(int $id)
    {
        return self::findOrFail($id);
    }

    public static function createUser($request)
    {
        $params = $request->getParsedBody() ?? [];

        $user = new self();
        $user->name = $params['name'] ?? '';
        $user->email = $params['email'] ?? '';
        $user->username = $params['username'] ?? '';

        if (!empty($params['password'])) {
            $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        }

        // users table uses "role", not "role_id"
        $user->role = $params['role'] ?? 4;

        $user->save();

        return $user;
    }

    public static function updateUser($request)
    {
        $params = $request->getParsedBody() ?? [];
        $id = $request->getAttribute('id');

        $user = self::findOrFail($id);

        foreach (['name', 'email', 'username', 'role'] as $field) {
            if (array_key_exists($field, $params)) {
                $user->$field = $params[$field];
            }
        }

        if (!empty($params['password'])) {
            $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        }

        $user->save();

        return $user;
    }

    public static function deleteUser($request)
    {
        $id = $request->getAttribute('id');
        $user = self::findOrFail($id);
        $user->delete();

        return $user;
    }

    public static function authenticateUser(string $username, string $password)
    {
        $user = self::where('username', $username)->first();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        return $user;
    }

    public static function generateJWT(int $user_id): string
    {
        $secret = self::getJwtSecret();

        $payload = [
            'iss' => 'courseProj Hotel Booking API',
            'aud' => 'courseProj API Client',
            'iat' => time(),
            'exp' => time() + 3600,
            'user_id' => $user_id
        ];

        return JWT::encode($payload, $secret, 'HS256');
    }

    public static function validateJWT(string $token)
    {
        $secret = self::getJwtSecret();

        return JWT::decode($token, new Key($secret, 'HS256'));
    }

    private static function getJwtSecret(): string
    {
        return 'courseProjHotelBookingSecretKey';
    }
}
