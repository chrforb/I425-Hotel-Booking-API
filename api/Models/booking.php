public function amenities() {
    return $this->belongsToMany(Amenity::class, 'booking_amenity', 'booking', 'amenity');
}
