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
<header class="page-header">	
	<div class="logo-box">
        Skykayaak
    </div>
</header>	
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #D6EAF8;
            color: #333;
            margin: 0;
            padding: 50px;
        }
        .tour-package {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
			margin-top: 20px;
			background-color: white;
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
		 
		.tour-package a {
            text-decoration: none; /* Removes underline */
        }
		.page-header {
            background-color: #D6EAF8; /* Assuming this is the background color of your header */
            padding: 10px 20px; /* Add some padding */
            text-align: left; /* Align the text to the left */
			padding-bottom: 20px
            width: 98%; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional: Adds shadow for some depth */
            z-index: 1000; /* Ensures the header stays above all other content */
			top : 0;
			left: 0;
			margin-top : 10px;
        }
		.logo-box {
            display: inline-block; /* Allows us to set padding and margins */
            background-color: #90EE90; /* Light green background */
            color: white;
            padding: 10px 20px;
            border-radius: 5px; /* Rounded corners */
            font-size: 30px;
            font-weight: bold;
			margin-top : 10px;
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
            <?php if ($package['destination'] == "Cox's Bazar"): ?>
                <!-- Cox's Bazar specific View Tour button -->
                <a href='coxsbazaar.php?tour_no=<?= $package['tour_no'] ?>'>
                    <button>View Cox's Bazar Tour</button>
                </a>
				
			<?php elseif ($package['destination'] == "Bandarban"): ?>
            <!-- Bandarban specific View Tour button -->
            <a href='bandarban.php?tour_no=<?= $package['tour_no'] ?>'>
                <button>View Bandarban Tour</button>
            </a>	
		    
			<?php elseif ($package['destination'] == "Chattogram"): ?>
                <!-- Chattogram specific View Tour button -->
                <a href='chattogram.php?tour_no=<?= $package['tour_no'] ?>'>
                    <button>View Chattogram Tour</button>
                </a>
			<?php elseif ($package['destination'] == "Saint-Martin"): ?>
                <!-- Saint-Martin specific View Tour button -->
                <a href='saintmartin.php?tour_no=<?= $package['tour_no'] ?>'>
                    <button>View Saint Martin Island Tour</button>
                </a>	
		    <?php elseif ($package['destination'] == "Sundarban"): ?>
                <!-- Sundarban specific View Tour button -->
                <a href='sundarban.php?tour_no=<?= $package['tour_no'] ?>'>
                    <button>View Sundarban Tour</button>
                </a>	
            <?php elseif ($package['destination'] == "Sylhet"): ?>
                <!-- SYlhet specific View Tour button -->
                <a href='sylhet.php?tour_no=<?= $package['tour_no'] ?>'>
                    <button>View Sylhet Tour</button>
                </a>				
            <?php else: ?>
                <button>View Tour</button>
            <?php endif; ?>
            <!-- Book Now Button form -->
            <form action='cart.php' method='post'>
                <input type='hidden' name='tour_no' value='<?= $package['tour_no'] ?>' />
                <input type='hidden' name='action' value='add_to_cart_tour' />
                <button type='submit'>Payment</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<script>
$(document).ready(function() {
    // Event handler for changes in selection
    $('.package-selection').on('change', 'select', function() {
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
                $('#price-for-' + tourNo).text('Total Price: ' + response.new_price + ' Taka');
            }
        });
    });
});
</script>

</body>
</html>
