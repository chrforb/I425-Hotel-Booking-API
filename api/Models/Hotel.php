<?php
/**
 * Author: Christian Forbes
 * Date: 6/7/2026
 * File: Hotel.php
 * Description: defines hotel model class
 */
namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;
use courseProj\Controllers\HotelController;

class Hotel extends Model
{
    protected $table = 'hotels';
    protected $primaryKey = 'hotel_id';
    public $incrementing = true;
    public $timestamps = false;

    public function rooms()
    {
        return $this->hasMany(Room::class, 'hotel_id');
    }

    public static function getHotels()
    {
        return self::all();
    }

    public static function getHotelById(int $id)
    {
        return self::with('rooms')->findOrFail($id);
    }

    public static function getRoomsByHotel(int $id)
    {
        return self::findOrFail($id)->rooms;
    }
}