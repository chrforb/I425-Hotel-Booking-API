public function bookings() {
    return $this->belongsToMany(Booking::class, 'booking_amenity', 'amenity', 'booking');
}

public static function getAmenitiesByBooking(string $id) {
    $amenities = self::findOrFail($id)->amenities;
    return $amenities;
}
