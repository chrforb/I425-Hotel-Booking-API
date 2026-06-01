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


