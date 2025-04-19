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
        <img src="sm1.png" alt="Tour Image 1">
        <img src="sm2.png" alt="Tour Image 2">
        <img src="sm3.png" alt="Tour Image 3">
    </div>
    <div class="description">
        <h2>Saint-Martin Island</h2>
        <p>
            
Indulge in the allure of Saint Martin, the pride of Bangladesh and a true gem in the Bay of Bengal. Fondly referred to as "Narikel Zinzira" in Bengali, translating to 'Coconut Island,' Saint Martin is renowned as the only coral reef island in Bangladesh. Its fame lies in the pristine beaches, where powdery sands meet azure waters, creating a tropical haven for relaxation. Beyond the shores, experience the island's vibrant culture through its delightful firework displays and savor the essence of coastal living with an abundance of delectable seafood. Immerse yourself in the unique charm of Saint Martin, where the combination of natural beauty, cultural richness, and culinary delights make it a must-visit destination for any traveler seeking a slice of paradise.
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