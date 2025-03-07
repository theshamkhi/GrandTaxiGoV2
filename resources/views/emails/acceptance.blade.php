<!DOCTYPE html>
<html>
<head>
    <title>Reservation Accepted</title>
</head>
<body>
    <h1>Your Taxi Reservation Has Been Accepted</h1>
    <p>Dear {{ $trip->passenger->name }},</p>
    <p>Your taxi reservation with ID {{ $trip->id }} has been accepted.</p>
    <p>Details of your trip:</p>
    <ul>
        <li>Pickup Location: {{ $trip->pickup_location }}</li>
        <li>Destination: {{ $trip->destination }}</li>
        <li>Date and Time: {{ $trip->departure_time }}</li>
    </ul>
    <p>Thank you for using our service!</p>
</body>
</html>