# Hotel Booking API

A RESTful backend API for managing hotel reservations, rooms, guests, amenities, and user authentication.

This project was developed as a team project for I425 and demonstrates backend API development, relational database design, authentication, and API testing.

## Technologies

- PHP
- Slim Framework
- MySQL
- REST API
- JWT Authentication
- Composer
- Postman

## Features

- Hotel management
- Room management
- Guest management
- Booking and reservation management
- Amenity management
- Relational MySQL database
- User account management
- Password hashing
- Token-based authentication
- JWT authentication
- Protected API routes
- API testing with Postman

## Database Design

The application uses a relational MySQL database containing tables for:

- Hotels
- Rooms
- Guests
- Bookings
- Amenities
- Booking amenities
- Users
- Roles
- Authentication tokens

The database was designed with relationships between hotels and rooms, guests and bookings, rooms and bookings, users and roles, and bookings and amenities.

## Authentication

The API includes multiple authentication workflows, including:

- Custom header authentication
- HTTP Basic authentication
- Bearer token authentication
- JWT authentication

Protected endpoints require valid authentication before accessing restricted resources.

## API Structure

The API follows REST principles and organizes resources under versioned endpoints.

Example resources include:

```text
/api/v1/hotels
/api/v1/rooms
/api/v1/guests
/api/v1/bookings
/api/v1/amenities
/api/v1/users
