<?php
session_start(); // Start the session 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect user input
    $email = $_POST['email'];
    $password = $_POST['password']; 

    // Database 
    $servername = "localhost";
    $username = "root";
    $dbpassword = ""; 
    $dbname = "flightandtour"; 

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL to check user info in the user_info table
    $sqlUserInfo = "SELECT NID, Password FROM user_info WHERE Email = ?";
    
    // Prepare and bind
    $stmtUserInfo = $conn->prepare($sqlUserInfo);
    $stmtUserInfo->bind_param("s", $email);

    // Execute the query
    $stmtUserInfo->execute();
    $result = $stmtUserInfo->get_result();

    if ($result->num_rows === 1) {
        // User found, now check password
        $row = $result->fetch_assoc();
        if ($row['Password'] === $password) {
            // Password is correct, insert into registered_users if not already registered
            $nid = $row['NID']; // Assume NID is the user's ID from user_info

            // Check if the user is already in registered_users
            $sqlCheckRegistered = "SELECT RU_NID FROM registered_users WHERE RU_NID = ?";
            $stmtCheckRegistered = $conn->prepare($sqlCheckRegistered);
            $stmtCheckRegistered->bind_param("i", $nid);
            $stmtCheckRegistered->execute();
            $resultCheck = $stmtCheckRegistered->get_result();
            $stmtCheckRegistered->close();

            // If not already registered, insert the user
            if ($resultCheck->num_rows === 0) {
                $sqlRegister = "INSERT INTO registered_users (RU_NID, Registered_No, email) VALUES (?, ?, ?)";
                $stmtRegister = $conn->prepare($sqlRegister);
                $registeredNo = ''; 
                $stmtRegister->bind_param("iss", $nid, $registeredNo, $email);
                $stmtRegister->execute();
                $stmtRegister->close();
            }

            // Set a session variable with the success message
            $_SESSION['login_success'] = "Login successful!";

            // Redirect to new_2.php
            header("Location: start_booking.php");
            exit();
        } else {
            // Password is incorrect, redirect to re.php with an error message
            $_SESSION['login_error'] = "Invalid email or password. Please register if you don't have an account.";
            header("Location: re.php");
            exit();
        }
    } else {
        // User not found, redirect to re.php with an error message
        $_SESSION['login_error'] = "Invalid email or password. Please register if you don't have an account.";
        header("Location: re.php");
        exit();
    }

    // Close statement and connection
    $stmtUserInfo->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white; /* White background for the page */
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Full height of the viewport */
            margin: 0;
        }
        h1 {
            color: #4CAF50; /* Green color for the heading */
        }
        form {
            background-color: #f9f9f9; /* Light grey background for the form */
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px; /* Width of the form */
        }
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%; /* Full width */
            padding: 15px;
            margin-bottom: 10px; /* Space between inputs */
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }
        input[type="submit"] {
            background-color: #4CAF50; /* Green background for the submit button */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }
        p {
            color: #ff0000; /* Red color for error messages */
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
    <h1>Flight Booking Login</h1>
    <?php
    if (isset($_SESSION['login_error'])) {
        echo "<p>" . $_SESSION['login_error'] . "</p>";
        unset($_SESSION['login_error']);
    }
    ?>
    <form method="POST" action="login.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
</body>
</html>
