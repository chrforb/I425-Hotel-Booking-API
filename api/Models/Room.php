<?php

namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'room_id';
    public $incrementing = true;
    public $timestamps = false;

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id');
    }

    public static function getRooms($request) {
        $count = self::count();

        $params = $request->getQueryParams();

        $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 10;
        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0;

        $query = self::query();

        if (array_key_exists('search', $params)) {
            $terms = explode(' ', trim($params['search']));

            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('room_number', 'like', "%$term%")
                        ->orWhere('room_type', 'like', "%$term%")
                        ->orWhere('status', 'like', "%$term%")
                        ->orWhere('price_per_night', 'like', "%$term%");
                });
            }
        }

        $count = $query->count();

        $query = $query->skip($offset)->take($limit);

        $sort_key_array = self::getSortKeys($request);

        foreach ($sort_key_array as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        $rooms = $query->get();

        $results = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'sort' => $sort_key_array,
            'data' => $rooms
        ];

        return $results;
    }

    private static function getSortKeys($request) {
        $sort_key_array = [];

        $params = $request->getQueryParams();

        if (array_key_exists('sort', $params)) {
            $sort = preg_replace('/^\[|]$|\s+/', '', $params['sort']);
            $sort_keys = explode(',', $sort);

            foreach ($sort_keys as $sort_key) {
                $direction = 'asc';
                $column = $sort_key;

                if (strpos($sort_key, ':')) {
                    list($column, $direction) = explode(':', $sort_key);
                }

                $sort_key_array[$column] = $direction;
            }
        }

        return $sort_key_array;
    }

    public static function getRoomById(int $id)
    {
        return self::findOrFail($id);
    }

    public static function getBookingsByRoom(int $id)
    {
        return self::findOrFail($id)->bookings;
    }

    public static function createRoom($request)
    {
        $params = $request->getParsedBody();

        $room = new Room();

        foreach ($params as $field => $value) {
            $room->$field = $value;
        }

        $room->save();
        return $room;
    }

    public static function updateRoom($request)
    {
        $params = $request->getParsedBody();

        $id = $request->getAttribute('id');

        $room = self::findOrFail($id);

        foreach ($params as $field => $value) {
            $room->$field = $value;
        }

        $room->save();
        return $room;
    }

    public static function deleteRoom($request)
    {
        $id = $request->getAttribute('id');
        $room = self::findOrFail($id);
        $room->delete();

        return $room;
    }
}
