<?php 

namespace I425-Hotel-Booking-API/api/Models;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
  {
    protected $table = 'tokens';
    protected $primarykey = 'id';
    public $timestamps = false;

    const EXPIRE = 3600;

    public statix function generateBearer(int $user_id)
    { 
      $token = bin2hex(random_bytes(16));
      $bearer = new Token();

      $bearer->user_id = $user_id;
      $bearer->token = $token;
      $bearer->expires = time() + self::EXPIRE;

      $bearer->save();

      return $token;

    }

    public static function validateBearer(string $token)
    {
      $bearer = self::where('token', $token)
        ->where('expires', '>', time())
        ->first();
      return $bearer;
    }
  }
