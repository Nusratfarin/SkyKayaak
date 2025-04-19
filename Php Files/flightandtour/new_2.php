<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Flight Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('image.png') no-repeat center center fixed; /* Reference to the uploaded image */
            background-size: cover;
            color: #333;
            margin: 0;
            height: 100vh; /* Full height */
            display: flex;
            align-items: center; /* Align vertical */
            justify-content: center; /* Align horizontal */
            position: relative; /* Needed for absolute positioning of the logo */
        }

        .logo-container {
            position: absolute; /* Absolute positioning */
            top: 0; /* At the top */
            left: 0; /* At the left */
            padding: 20px; /* Padding from the edge of the page */
        }

        .logo {
            font-family: 'Times New Roman', sans-serif;
            font-size: 32px;
            font-weight: bold;
            color: white; /* White text color for contrast */
            background-color: lightgreen; /* Logo background color */
            padding: 5px 10px;
            border-radius: 5px;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .button {
            padding: 15px 30px;
            margin: 10px;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            text-align: center;
        }

        .button:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .start-booking {
            background-color: #4CAF50; /* Green */
        }

        .register {
            background-color: #008CBA; /* Blue */
        }

        .log-in {
            background-color: #555555; /* Dark Grey */
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <div class="logo">SkyKayak</div>
    </div>
    <div class="button-container">
        <button class="button start-booking" onclick="location.href='start_booking.php'">START BOOKING</button>
        <button class="button register" onclick="location.href='re.php'">REGISTER</button>
        <button class="button log-in" onclick="location.href='login.php'">LOG IN</button>
    </div>
</body>
</html>

