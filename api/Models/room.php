<?php

namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'room_id';
    public $incrementing = true;
    public $timestamps = false;

    public static function getRooms()
    {
        return self::all();
    }

    public static function getRoomById(int $id)
    {
        return self::findOrFail($id);
    }

    public static function deleteRoom(int $id)
    {
        $room = self::findOrFail($id);
        $room->delete();
        return $room;
    }
    $group->delete('/{id}', 'Room:delete');

    public static function searchRooms(string $terms)
    {
    $keywords = explode(' ', trim($terms));

    $query = self::query();

    foreach ($keywords as $keyword) {
        $query->orWhere('room_number', 'LIKE', "%$keyword%")
              ->orWhere('room_type', 'LIKE', "%$keyword%")
              ->orWhere('description', 'LIKE', "%$keyword%");
        }

    return $query->get();
    }
}
