<?php
session_start(); // Start the session to use session variables

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flightandtour";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emailExists = false;

// Only process the form if it's submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM user_info WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $emailExists = true;
    } else {
        // Collect other user input
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $phoneNo = $_POST['phone_no'];
        $password = $_POST['password']; 

        // Insert user data into the database
        $insert_stmt = $conn->prepare("INSERT INTO user_info (first_name, last_name, email, phone_no, password) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("sssss", $firstName, $lastName, $email, $phoneNo, $password);
        $insert_stmt->execute();

        // Redirect to booking page
        header("Location: start_booking.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white; /* Background is white */
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Full height */
            margin: 0;
        }
        form {
            background-color: #f9f9f9; /* Light grey background for the form */
            padding: 40px; /* Increased padding */
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 500px; /* Increased width */
        }
        label {
            display: block;
            margin-top: 20px; /* Increased spacing */
            margin-bottom: 10px; /* Increased spacing */
            font-size: 20px; /* Larger font size */
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 20px); /* Full width minus padding */
            padding: 15px; /* Larger padding */
            margin-bottom: 20px; /* Increased spacing */
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 18px; /* Larger font size */
        }
        input[type="submit"] {
            width: 100%;
            padding: 15px; /* Larger padding */
            border: none;
            border-radius: 5px;
            background-color: #4CAF50; /* Green background for submit button */
            color: white;
            font-size: 20px; /* Larger font size */
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
		.error-message {
           color: red;
           margin-top: 20px;
           text-align: center;
           font-size: 18px;
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

    </style>
</head>
<body>
    <div class="logo-container">
        <div class="logo">SkyKayak</div>
    </div>
    <div class="form-container"> 
        <?php if ($emailExists): ?>
            <div class="error-message">
                The email is already registered. Please use another email.
            </div>
        <?php endif; ?>




    <!-- Registration form -->
    <form method="post" action="re.php">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="phone_no">Phone Number:</label>
        <input type="text" name="phone_no" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Register">
    </form>
</body>
</html>

