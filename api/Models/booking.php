namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // table associated with model
    protected $table = 'bookings';

    // primary key of the table
    protected $primaryKey = 'booking_id';

    // if PK is auto incrementing
    public $incrementing = true;

    // if created_at and updated_at are not used
    public $timestamps = false;

 // Many-to-many relationship with amenities
    public function amenities()
    {
        return $this->belongsToMany(
            Amenity::class,
            'booking_amenity',
            'booking',
            'amenity'
        );
    }
    // Booking belongs to one guest
    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    // retrieve all bookings
    public static function getBookings()
    {
        $bookings = self::with(['amenities', 'guest'])->get();
        return $bookings;
    }

    // retrieve specific booking
    public static function getBookingById(int $id)
    {
        $booking = self::findOrFail($id);
        $booking->load('amenities')
                ->load('guest');

        return $booking;
    }


