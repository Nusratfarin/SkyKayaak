<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "flightandtour";

// Create database connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Function to get tour packages
function getTourPackages($db) {
    // Fetch tour packages from the database
    $result = $db->query("SELECT * FROM tour_packages");
    $packages = [];
    
    while($row = $result->fetch_assoc()) {
        array_push($packages, $row);
    }
    return $packages;
}

// Handle the AJAX request to update the price
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_price') {
    $tourNo = $_POST['tour_no'];
    $totalPersons = $_POST['total_persons'];
    $totalDays = $_POST['total_days'];

    // Query to get the price per day from the database
    $query = $db->prepare("SELECT price_per_day FROM tour_packages WHERE tour_no = ?");
    $query->bind_param("i", $tourNo);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    $pricePerDay = $row['price_per_day'];

    $newPrice = $pricePerDay * $totalDays * $totalPersons;

    // Return the new price
    header('Content-Type: application/json');
    echo json_encode(['new_price' => $newPrice]);
    exit;
}

// If not an AJAX request, continue to load the page normally
$tourPackages = getTourPackages($db);

// Always close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tour Packages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .tour-package {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h3 {
            color: #4CAF50;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        button:hover {
            background-color: #45a049;
        }
        .package-selection {
            margin: 10px 0;
        }
        select {
            padding: 5px;
            margin-right: 10px;
        }
        p {
            margin: 5px 0;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div id="tour-packages">
    <?php foreach ($tourPackages as $package): ?>
        <div class='tour-package'>
            <h3><?= htmlspecialchars($package['destination']) ?></h3>
            <p><?= htmlspecialchars($package['price_per_day']) ?> Taka per person</p>
            <div class='package-selection' data-tour-no='<?= $package['tour_no'] ?>'>
                <select class='total-persons'>
                    <?php for ($i = 1; $i <= 9; $i++): ?>
                        <option value='<?= $i ?>'><?= $i ?> Person<?= $i > 1 ? 's' : '' ?></option>
                    <?php endfor; ?>
                </select>
                <select class='total-days'>
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                        <option value='<?= $i ?>'><?= $i ?> Day<?= $i > 1 ? 's' : '' ?></option>
                    <?php endfor; ?>
                </select>
                <p id='price-for-<?= $package['tour_no'] ?>'>Total Price: <?= $package['total_price'] ?></p>
            </div>
            <button>View Tour</button>
            <!-- Book Now Button form -->
            <button class="button" onClick="onButtonClick(<?php echo  $package['total_price']; ?>)">Payment</button>
    <?php endforeach; ?>
</div>

<script>
let totalPrice = 0;
$(document).ready(function() {
    // Event handler for changes in selection
    $('.package-selection').on('change', 'select', function() {
		totalPrice = 0;
        var tourNo = $(this).closest('.package-selection').data('tour-no');
        var totalPersons = $(this).closest('.package-selection').find('.total-persons').val();
        var totalDays = $(this).closest('.package-selection').find('.total-days').val();

        // Make an AJAX call to update the price based on selection
        $.ajax({
            url: 'tour.php',
            type: 'POST',
            data: {
                action: 'update_price',
                tour_no: tourNo,
                total_persons: totalPersons,
                total_days: totalDays
            },
            success: function(response) {
                // Update the price on the page
				totalPrice =  response.new_price;
                $('#price-for-' + tourNo).text('Total Price: ' + response.new_price + ' Taka');
            }
        });
    });
});
function onButtonClick(){
	   const url = `http://localhost/flightandtour/payment.php?amount=${totalPrice}`;
	   window.location.href=url;
   }
</script>

</body>
</html>
