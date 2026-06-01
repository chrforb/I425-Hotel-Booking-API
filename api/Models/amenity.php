
namespace courseProj\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    // table associated with model
    protected $table = 'amenities';

    // primary key
    protected $primaryKey = 'amenity_id';

    // no timestamps
    public $timestamps = false;

    // Many-to-many: Amenity ↔ Booking
    public function bookings()
    {
        return $this->belongsToMany(
            Booking::class,
            'booking_amenity',
            'amenity',
            'booking'
        );
    }

    // retrieve all amenities
    public static function getAmenities()
    {
        return self::with('bookings')->get();
    }

    // retrieve single amenity
    public static function getAmenityById(string $id)
    {
        $amenity = self::findOrFail($id);
        $amenity->load('bookings');

        return $amenity;
    }
}
