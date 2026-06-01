public function amenities() {
    return $this->belongsToMany(Amenity::class, 'booking_amenity', 'booking', 'amenity');
}
public static function getBookings() {
    $bookings = self::with('amenities')->get();
    return $bookings;
}
public static function getBookingById(string $id) {
    $booking = self::findOrFail($id);
    $booking->load('amenities');
    return $booking;
}
