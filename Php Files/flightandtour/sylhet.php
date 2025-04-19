<!DOCTYPE html>
<html>
<head>
    <title>Skykayaak - Tour Plan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FAF9F6; /* Set background to light green */
        }

        .container {
            width: 80%;
            margin: auto;
            background-color: #E6E6FA; /* Semi-transparent white */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .heading {
            color: darkgreen; /* Heading color set to dark green */
            margin-bottom: 10px;
        }
        
        .subheading {
            color: green; /* Subheading color set to light green */
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .image-grid img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .description {
            margin-top: 20px;
            text-align: justify;
            font-family: 'Times New Roman', serif; /* Times New Roman font */
            background-color: #f8f8f8; /* Light background for the box */
            padding: 15px;
            border-radius: 5px;
            
        }
         
        .button {
            background-color: green; /* Green background color for buttons */
            color: white; /* White text color for contrast */
            padding: 5px 10px; /* Padding for button size */
            border: none; /* No border for a cleaner look */
            border-radius: 5px; /* Rounded corners for aesthetics */
            cursor: pointer; /* Pointer cursor on hover for usability */
            margin: 10px; /* Margin around buttons */
            font-size: 16px; /* Font size for readability */
            text-transform: uppercase; /* Making the text uppercase for a more stylized look */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        .button:hover {
            background-color: darkgreen; /* Darker green on hover for interactivity */
        }



    </style>
</head>
<body>

<div class="container">
    <h1 class="heading">Welcome to Skykayaak</h1>
    <h2 class="subheading">Skykayaak providing you the best and most secure tour plan in   the country</h2>
    <div class="image-grid">
        <img src="sy1.jpg" alt="Tour Image 1">
        <img src="sy2.png" alt="Tour Image 2">
        <img src="sy3.png" alt="Tour Image 3">
    </div>
    <div class="description">
        <h2>Sylhet</h2>
        <p>
            


Discover the enchanting allure of Sylhet with our meticulously crafted tour plan that unveils the perfect blend of nature's wonders and cultural treasures. Begin your journey in the picturesque Shunamganj, nestled at the foothills of the Himalayas. Experience the breathtaking Teharpur, where clouds gracefully dance over a serene lake during an unforgettable boat stay.

Immerse yourself in the lush landscapes of the Tea Gardens, where rolling hills adorned with tea bushes create a stunning visual symphony. Engage in the art of tea cultivation, surrounded by the crisp mountain air in these verdant plantations.

Explore the vibrant streets of Sylhet city, where history and culture come to life. From ancient landmarks to bustling markets, each stop in the itinerary unfolds a unique story, providing a glimpse into the rich heritage of the region. Join us for an unforgettable tour that seamlessly blends the tranquility of nature with the vibrant hues of local life in Sylhet.
        </p>
    <div>
     <a href="tour.php" style="text-decoration: none;">
        <button class="button">VIEW OTHER TOUR PACKAGES</button>
    </a>
    </div>


    </div>
</div>

</body>
</html>