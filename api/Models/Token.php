<?php
namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens';
    protected $primaryKey = 'token_id';
    public $timestamps = false;

    protected $fillable = ['user_id', 'token'];

    public static function generateBearer(int $user_id)
    {
        $token = bin2hex(random_bytes(32));

        self::create([
            'user_id' => $user_id,
            'token' => $token
        ]);

        return $token;
    }

    public static function validateBearer(string $token)
    {
        return self::where('token', $token)->exists();
    }
}