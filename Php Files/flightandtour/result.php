<?php

// Database configuration
$host = "localhost";
$dbname = "flightandtour";
$username = "root"; //
$password = ""; // 

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Set the default value for num_persons
$numPersons  = isset($_POST['num_persons']) ? $_POST['num_persons'] : 1;
//echo "Number of Persons from Form: " . $numPersons  . "<br>";

// form 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart_flight'])) {
    $flightId = $_POST['flight_id'];
    $flightPrice = $_POST['flight_price'];
	$numPersons = $_POST['num_persons'];
	
	

    //  $db is  database connection variable
    $stmt = $conn->prepare("INSERT INTO cart (flight_id, flight_price, num_persons) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $flightId, $flightPrice, $numPersons  );
    $stmt->execute();
	
    
}

// Initialize variables
$flights = [];
$searchPerformed = isset($_POST['from']) && isset($_POST['to']);


// Collect input from the form
$from = $_POST['from'] ?? '';
$to = $_POST['to'] ?? '';



if ($searchPerformed) {
    // Prepare the SQL query
    $sql = "SELECT * , departure_time, arrival_time  FROM flight_info WHERE `from` = ? AND `to` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $from, $to);

    
    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all the matching flights
    $flights = $result->fetch_all(MYSQLI_ASSOC);
	
	// Calculate the total price based on the number of persons
    foreach ($flights as &$flight) {
		//echo "No of Persons: " . $numPersons  . "<br>";
        $flight['final_price'] = $flight['price'] * $numPersons ;
		
    }



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
		.book-button {
			display: inline-block;
			padding: 12px 24px;
			margin: 10px 0;
			color: white;
			background-color: #28a745;
			text-decoration: none;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s ease;
			
	    }
		
		
		
		.success-message {
			background-color: #28a745; 
			color: white;
			padding: 10px;
			border-radius: 5px;
			margin-top: 10px;
			display: inline-block;
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
						<th>Departure</th>
						<th>Arrival</th>
						
                    </tr>
                    <?php foreach ($flights as $flight): ?>
						<tr>
							<td><?= htmlspecialchars($flight['flight_id']) ?></td>
							<td><?= htmlspecialchars($flight['from']) ?></td>
							<td><?= htmlspecialchars($flight['to']) ?></td>
							<td><?= htmlspecialchars($flight['price'] * $numPersons ) ?></td>
							<td><?= htmlspecialchars($flight['departure_time']) ?></td>
							<td><?= htmlspecialchars($flight['arrival_time']) ?></td>
							<td>
								<form action="result.php" method="post">
									<input type="hidden" name="flight_id" value="<?= $flight['flight_id'] ?>">
									<input type="hidden" name="flight_price" value="<?= $flight['price'] * $numPersons  ?>">
									<input type="hidden" name="num_persons" value="<?= $numPersons  ?>">
									<button type="submit" name="add_to_cart_flight" class="book-button">Book</button>
								</form>
							</td>
						</tr>
					<?php endforeach; ?>
                </table>
                <button class="button" onclick="window.location.href='payment.php'">Payment</button>
            <?php else: ?>
                <div class="no-flights">No flights available.</div>
            <?php endif; ?>
            <button class="button button-back" onclick="history.back()">Back to Search</button>
        <?php endif; ?>
		
		<!--Success message-->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart_flight'])): ?>
            <?php if ($stmt->affected_rows > 0): ?>
                <div class="success-message">Flight successfully added to cart!</div>
            <?php else: ?>
                <div class="error-message">Failed to add flight to cart. Please try again.</div>
            <?php endif; ?>
        <?php endif; ?>
		
	
		<!-- Back button -->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart_flight'])): ?>
            <button class="button button-back" onclick="history.back()">Back to Search</button>
        <?php endif; ?>

    </div>
</body>
</html>
