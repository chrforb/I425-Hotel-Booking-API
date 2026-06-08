<?php
/**
 * Author: Christian Forbes
 * Date: 5/31/2026
 * File: Guest.php
 * Description: defines the guest model
 */


/**
 * Author: Christian Forbes
 * Date: 5/31/2026
 * File: Guest.php
 * Description: define Guest model class
 */

namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{

    // table associated with model
    protected $table = 'guests';

    // primary key of the table
    protected $primaryKey = 'guest_id';

    // if PK is auto incrementing
    public $incrementing = true;

    // if created_at and updated_at are not used
    public $timestamps = false;

     public function bookings()
    {
        return $this->hasMany(Booking::class, 'guest_id');
    }

    // retrieve all guests
    public static function getGuests($request)
    {
        $count = self::count();

        $params = $request->getQueryParams();

        $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 10;
        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0;

        $query = self::query();

        $query = $query->skip($offset)->take($limit);

        $sort_key_array = self::getSortKeys($request);

        foreach ($sort_key_array as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        $guests = $query->get();

        $results = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'sort' => $sort_key_array,
            'data' => $guests
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

    // retrieve specific guest
    public static function getGuestById(int $id)
    {
        $guest = self::findOrFail($id);
        $guest->load('bookings');
        return $guest;
    }

     public static function getBookingsByGuest(int $id)
    {
        $bookings = self::findOrFail($id)->bookings;
        return $bookings;
    }

    public static function createGuest($request)
    {
        $params = $request->getParsedBody();

        $guest = new Guest();

        foreach ($params as $field => $value) {
            $guest->$field = $value;
        }

        $guest->save();
        return $guest;
    }

    public static function updateGuest($request)
    {
        $params = $request->getParsedBody();

        $id = $request->getAttribute('id');

        $guest = self::findOrFail($id);

        foreach ($params as $field => $value) {
            $guest->$field = $value;
        }

        $guest->save();
        return $guest;
    }
}
