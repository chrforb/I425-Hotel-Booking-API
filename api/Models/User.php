<?php
/**
 * Author: Christian Forbes
 * Date: 6/14/2026
 * File: User.php
 * Description: defines user model class
 */


namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class User extends Model
{
    const JWT_KEY = 'courseProj-api-2026-ChristianForbes-SecureJWTKey$123';
    const JWT_EXPIRE = 3600;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    public static function createUser($request)
    {
        $params = $request->getParsedBody();
        $user = new User();

        foreach ($params as $field => $value) {
            $user->$field = ($field === "password")
                ? password_hash($value, PASSWORD_DEFAULT)
                : $value;
        }

        $user->save();
        return $user;
    }

    public static function authenticateUser($username, $password)
    {
        $user = self::where('username', $username)->first();

        if (!$user) {
            return false;
        }

        return password_verify($password, $user->password) ? $user : false;
    }

    public static function generateJWT($id)
    {
        $user = self::find($id);

        if (!$user) {
            return false;
        }

        $payload = [
            'iss' => 'courseProj-api.com',
            'iat' => time(),
            'exp' => time() + self::JWT_EXPIRE,
            'data' => [
                'uid' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ];

        return JWT::encode($payload, self::JWT_KEY, 'HS256');
    }

    public static function validateJWT($jwt)
    {
        return JWT::decode($jwt, new Key(self::JWT_KEY, 'HS256'));
    }
}