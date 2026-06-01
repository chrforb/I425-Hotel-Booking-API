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
    public static function getGuests()
    {
        $guests = self::all();
        return $guests;
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
}
