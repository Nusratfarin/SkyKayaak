<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyKayak - Start Booking</title>
    <style>
        
		body {
            background-image: url("kayyakimg.jpg");
            background-size: cover;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5);
        }

        .logo-container {
            display: flex;
            align-items: center;
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

        .tour-package-btn {
            background-color: lightgreen; /* Light green background */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            margin-top: 10px; /* Space above the button */
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            width: 100%; /* Button takes full width of its container */
        }
		.sign-up-btn, .comment-btn{
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            background-color: lightgreen;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin-left: 10px;
            color: white;
        }

        .currency-btn {
            background-color: lightgreen;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin-left: 10px;
            color: white;
        }

        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
        }

        .search-box {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            width: 60%;
            text-align: center;
        }

        .search-box label {
            display: block;
            margin-bottom: 5px;
        }

        .search-button, .tour-package-btn {
            background-color: lightgreen;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px; /* Space between the Search and Tour Package buttons */
        }

        select, input[type="date"], input[type="text"], input[type="range"], input[type="number"] {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            font-family: 'Arial', sans-serif;
        }

        .options-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .option-input {
            width: 48%;
        }

        .price-range-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .price-range {
            width: 100%;
            -webkit-appearance: none;
            appearance: none;
            height: 5px;
            background: lightgreen;
            outline: none;
            border-radius: 5px;
        }

        .slider-button {
            width: 20px;
            height: 20px;
            background: lightgreen;
            border-radius: 50%;
            cursor: pointer;
            margin-top: 5px;
            position: relative;
        }

        .price-range-input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }
		.review-btn {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            background-color: lightgreen;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin-left: 10px;
            color: white;
        }
		
        body {
            background-image: url("kayyakimg.jpg");
            background-size: cover;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5);
        }

        .logo-container {
            display: flex;
            align-items: center;
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

        
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <div class="logo">SkyKayak</div>
        </div>
        <div>
            <button class="currency-btn">
                <select>
                    <option value="dollar">$ USD</option>
                    <option value="taka">৳ Taka</option>
                </select>
            </button>
            <button class="sign-up-btn" onclick="location.href='re.php'">Sign Up</button>
            <button class="comment-btn" onclick="location.href='comment.php'">Comments</button>
            <button class="review-btn" onclick="location.href='review.php'">Review</button> 
        </div>
    </div>

    <div class="search-container">
        <div class="search-box">
            <form action="result.php" method="post">
                <div class="options-container">
                    <div class="option-input">
                        <label for="from">From:</label>
                        <input type="text" id="from" name="from" placeholder="Start Location" required>
                    </div>
                    <div class="option-input">
                        <label for="to">To:</label>
                        <input type="text" id="to" name="to" placeholder="Destination" required>
                    </div>
                </div>

                <div class="options-container">
                    <div class="option-input">
                        <label for="departure_date">Departure Date:</label>
                        <input type="date" id="departure_date" name="departure_date" required>
                    </div>
                    <div class="option-input">
                        <label for="return_date">Return Date:</label>
                        <input type="date" id="return_date" name="return_date">
                    </div>
                </div>

                <div class="options-container">
                    <div class="option-input">
                        <label for="travel_class">Travel Class:</label>
                        <select id="travel_class" name="travel_class" required>
                            <option value="economy">Economy</option>
                            <option value="business">Business</option>
                            <option value="first_class">First Class</option>
                        </select>
                    </div>
                    <div class="option-input">
                        <label for="num_persons">Number of Persons:</label>
                        <input type="number" id="num_persons" name="num_persons" min="1">
                    </div>
                </div>

                <div class="options-container">
                    <label for="price_range">Price Range:</label>
                    <input type="text" id="price_range" name="price_range" class="price-range-input" placeholder="5000-9000" required>
                </div>

                <button type="submit" class="search-button">Search</button>
				
            </form>
            <button class="tour-package-btn" onclick="location.href='tour.php'">Tour Packages</button>
        </div>
    </div>
</body>
</html>
