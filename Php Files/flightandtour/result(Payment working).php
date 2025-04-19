<?php
$amount= 0;
// Database configuration
$host = "localhost";
$dbname = "flightandtour";
$username = "root"; // Replace with your actual username
$password = ""; // Replace with your actual password


// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Place this snippet at the top of your result.php file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart_flight'])) {
    $flightId = $_POST['flight_id'];
    $flightPrice = $_POST['flight_price'];

    // Assuming $db is your database connection variable
    $stmt = $conn->prepare("INSERT INTO cart (flight_id, flight_price) VALUES (?, ?)");
    $stmt->bind_param("sd", $flightId, $flightPrice);
    $stmt->execute();
    // You might want to add some error handling and success message here
}

// Initialize variables
$flights = [];
$searchPerformed = isset($_POST['from']) && isset($_POST['to']);

// Collect input from the form
$from = $_POST['from'] ?? '';
$to = $_POST['to'] ?? '';

if ($searchPerformed) {
    // Prepare the SQL query
    $sql = "SELECT * FROM flight_info WHERE `from` = ? AND `to` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $from, $to);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all the matching flights
    $flights = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            text-align: center;
        }
        table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: lightgreen;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        .button, .button-back {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            color: white;
            background-color: lightgreen;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button-back {
            background-color: #6c757d;
        }
        .no-flights {
            background-color: #ffcccc;
            padding: 10px;
            border: 1px solid #ff8080;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <?php if ($searchPerformed): ?>
            <?php if (!empty($flights)): ?>
                <h1>Available Flights</h1>
                <table>
                    <tr>
                        <th>Flight ID</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Price</th>
                    </tr>
                    <?php foreach ($flights as $flight): ?>
                    <tr>
                        <td><?= htmlspecialchars($flight['flight_id']) ?></td>
                        <td><?= htmlspecialchars($flight['from']) ?></td>
                        <td><?= htmlspecialchars($flight['to']) ?></td>
                        <td><?= htmlspecialchars($flight['price']) ?></td>
                    </tr>
                    <?php $amount = $flight['price'];
					endforeach; ?>
                </table>
                
			    <button class="button" onClick="onButtonClick(<?php echo $amount; ?>)" >Payment</button>
				
            <?php else: ?> 
                <div class="no-flights">No flights available.</div>
            <?php endif; ?>
            <button class="button button-back" onclick="history.back()">Back to Search</button>
        <?php endif; ?>
    </div>
</body>
<script type="text/javascript">
   function onButtonClick(amount){
	   const url = `http://localhost/flightandtour/payment.php?amount=${amount}`;
	   window.location.href=url;
   }
</script>
</html>
