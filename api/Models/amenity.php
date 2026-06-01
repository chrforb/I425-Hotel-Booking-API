public function bookings() {
    return $this->belongsToMany(Booking::class, 'booking_amenity', 'amenity', 'booking');
}
