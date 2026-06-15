<?php
/**
 * Author: Course Project Team
 * Date: 6/15/2026
 * File: user.php
 * Description: Define the User model class.
 */

namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $hidden = ['password'];

    public static function getUsers()
    {
        return self::with('role')->get();
    }

    public static function getUserById(int $id)
    {
        return self::with('role')->findOrFail($id);
    }

    public static function createUser($request)
    {
        $params = $request->getParsedBody();

        $user = new User();
        $user->name = $params['name'];
        $user->email = $params['email'];
        $user->username = $params['username'];
        $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        $user->role_id = $params['role_id'] ?? 2;
        $user->save();

        return self::getUserById($user->id);
    }

    public static function updateUser($request)
    {
        $id = (int)$request->getAttribute('id');
        $params = $request->getParsedBody();
        $user = self::findOrFail($id);

        foreach (['name', 'email', 'username', 'role_id'] as $field) {
            if (array_key_exists($field, $params)) {
                $user->$field = $params[$field];
            }
        }

        if (!empty($params['password'])) {
            $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        }

        $user->save();
        return self::getUserById($user->id);
    }

    public static function deleteUser($request)
    {
        $id = (int)$request->getAttribute('id');
        $user = self::findOrFail($id);
        return $user->delete();
    }

    public static function authenticateUser(string $username, string $password)
    {
        $user = self::where('username', $username)->first();

        if (!$user) {
            return false;
        }

        return password_verify($password, $user->password) ? $user : false;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
