# GrandTaxiGo 🚖

GrandTaxiGo is a platform that allows passengers to easily book grand taxis and enables drivers to manage their trips and availability. It features a review system, flexible authentication, and secure payments.

## Features ✨

### 🛡️ Authentication & Account
- **User Registration**: Create an account as a passenger or driver with a mandatory profile photo and personal details.
- **Login**: Secure login to access and manage profiles.
- **Enhanced Authentication**: Sign in via Google or Facebook using Laravel Socialite.

### 📅 Booking & Trip Management
- **Reserve Taxis**: Passengers can book taxis by specifying the date, pickup location, and destination.
- **Trip History**: View past trips (reservations for passengers, completed rides for drivers).
- **Cancel Reservations**: Passengers can cancel bookings within a set timeframe (up to 1 hour before departure).
- **Driver Filtering**: Filter drivers by location and availability.
- **Driver Controls**: Accept/reject reservations. Unaccepted reservations past departure time are auto-canceled.
- **Availability Updates**: Drivers can update their availability status.

### 📊 Administrative Management
- **Admin Dashboard**: Manage users (drivers/passengers), monitor trips, and view detailed statistics (rides completed, cancellations, revenue, etc.).
- **Supervision Tools**: Track reservations and driver availability.

### ⭐ Reviews & Ratings
- **Passenger Reviews**: Rate and comment on drivers after a trip.
- **Driver Feedback**: Drivers can rate passengers based on behavior.
- **Transparent Profiles**: Display reviews on user profiles.

### 💳 Secure Payment
- **Online Payments**: Integrated Stripe payment gateway for secure in-app transactions.

### 🤖 Automation & Notifications
- **Smart Availability**: Automatically update driver availability based on current/upcoming trips.
- **Real-Time Notifications**: Email alerts for reservation updates (e.g., QR code upon driver acceptance).