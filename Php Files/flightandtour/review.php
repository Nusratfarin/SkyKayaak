<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flightandtour";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tour_no']) && isset($_POST['rating'])) {
    $tour_no = $_POST['tour_no'];
    $rating = $_POST['rating'];

    $stmt = $conn->prepare("INSERT INTO tour_reviews (tour_no, rating) VALUES (?, ?)");
    $stmt->bind_param("ii", $tour_no, $rating);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to show updated average
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch tour packages and their average ratings
$tour_packages_query = "SELECT tp.tour_no, tp.destination, COALESCE(AVG(tr.rating), 0) as avg_rating
                        FROM tour_packages tp
                        LEFT JOIN tour_reviews tr ON tp.tour_no = tr.tour_no
                        GROUP BY tp.tour_no, tp.destination";
$tour_packages_result = $conn->query($tour_packages_query);
?>

<?php
// Your existing PHP code
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tour Package Reviews</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            color: green;
        }
		
		.header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5);
			padding-bottom : 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
			padding-bottom: 20px;
			
        }

        .logo {
            font-family: 'Times New Roman', serif;
            font-size: 32px;
            font-weight: bold;
            color: white;
            background-color: lightgreen;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color:#D6EAF8 ;
			padding-top : 20px;
        }
        .tour-package {
            background-color: #fff;
            border: 1px solid #e7e7e7;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
        }
        .tour-package h2 {
            color: #0a3e26;
        }
        .star-rating {
            direction: rtl;
            font-size: 0;
            margin-bottom: 10px;
        }
        .star-rating input[type="radio"] {
            display: none;
        }
        .star-rating label {
            display: inline-block;
            position: relative;
            color: #bbb;
            font-size: 28px;
            cursor: pointer;
        }
        .star-rating label:before {
            content: "★";
            position: absolute;
            opacity: 0;
        }
        .star-rating label:hover:before,
        .star-rating label:hover ~ label:before,
        .star-rating input[type="radio"]:checked ~ label:before {
            opacity: 1;
            color: #0a3e26;
        }
        button {
            background-color:#4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 16px;
        }
        button:hover {
            background-color: #0d662b;
        }
        p.avg-rating {
            font-weight: bold;
            color: #0a3e26;
        }
		.back-btn {
            background-color: #4CAF50; /* Green background */
            color: white;
            padding: 10px 20px;
            margin: 20px 0;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none; /* Remove underline from links */
            font-size: 16px;
            display: inline-block; /* Allows to set padding and margins */
        }
        .back-btn:hover {
            background-color: #367c39; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tour Package Reviews</h1>
        <div class="logo-container">
            <div class="logo">SkyKayaak</div>
        </div>
        <?php while ($row = $tour_packages_result->fetch_assoc()): ?>
            <div class="tour-package">
                <h2><?php echo htmlspecialchars($row['destination']); ?></h2>
                <form action="" method="post">
                    <input type="hidden" name="tour_no" value="<?php echo $row['tour_no']; ?>">
                    <div class="star-rating">
                        <input type="radio" id="star5-<?php echo $row['tour_no']; ?>" name="rating" value="5"><label for="star5-<?php echo $row['tour_no']; ?>">★</label>
                        <input type="radio" id="star4-<?php echo $row['tour_no']; ?>" name="rating" value="4"><label for="star4-<?php echo $row['tour_no']; ?>">★</label>
                        <input type="radio" id="star3-<?php echo $row['tour_no']; ?>" name="rating" value="3"><label for="star3-<?php echo $row['tour_no']; ?>">★</label>
                        <input type="radio" id="star2-<?php echo $row['tour_no']; ?>" name="rating" value="2"><label for="star2-<?php echo $row['tour_no']; ?>">★</label>
                        <input type="radio" id="star1-<?php echo $row['tour_no']; ?>" name="rating" value="1"><label for="star1-<?php echo $row['tour_no']; ?>">★</label>
                    </div>
                    <button type="submit">Rate</button>
                </form>
                <p class="avg-rating">Rating: <?php echo round($row['avg_rating'], 1); ?> stars</p>
            </div>
        <?php endwhile; ?>
		<a href="start_booking.php" class="back-btn"> Book Your Flights </a>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
