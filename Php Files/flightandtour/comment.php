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

// Function to display comments and replies
function displayCommentsAndReplies($db) {
    // Fetch all comments
    $commentsQuery = "SELECT * FROM comments";
    $commentsResult = $db->query($commentsQuery);
    
    while ($commentRow = $commentsResult->fetch_assoc()) {
        echo "<div class='comment'>";
        // Show the email and then the comment
        echo "<p><strong>" . htmlspecialchars($commentRow['email']) . ":</strong> " . htmlspecialchars($commentRow['comment']) . "</p>";
        
        // Fetch replies for this comment
        $repliesQuery = "SELECT replies.reply, replies.email FROM replies WHERE replies.comment_id = " . $commentRow['comment_id'];
        $repliesResult = $db->query($repliesQuery);

        while ($replyRow = $repliesResult->fetch_assoc()) {
            // Check if the reply is from an admin
            $isFromAdmin = isAdminEmail($db, $replyRow['email']);
            $prefix = $isFromAdmin ? "Admin: " : "";

            echo "<div class='reply'>" . $prefix . htmlspecialchars($replyRow['reply']) . "</div>";
        }
        echo "</div>";
    }
}

// Function to check if the email is an admin email
function isAdminEmail($db, $email) {
    $adminCheck = $db->prepare("SELECT email FROM customer_support WHERE email = ?");
    $adminCheck->bind_param("s", $email);
    $adminCheck->execute();
    $result = $adminCheck->get_result();
    return $result->num_rows > 0;
}


// Function to post a comment
function postComment($db, $email, $comment) {
    // Check if the email exists in user_info
    $userCheck = $db->prepare("SELECT email FROM user_info WHERE email = ?");
    $userCheck->bind_param("s", $email);
    $userCheck->execute();
    $userResult = $userCheck->get_result();
    
    if ($userResult->num_rows === 1) {
        // Email exists in user_info, insert comment
        $insertComment = $db->prepare("INSERT INTO comments (email, comment) VALUES (?, ?)");
        $insertComment->bind_param("ss", $email, $comment);
        $insertComment->execute();
        echo "Comment posted successfully.";
    } else {
        echo "User email not recognized or not allowed to comment.";
    }
}

// Function to post a reply
function postReply($db, $email, $commentId, $reply) {
    // Check if the email exists in customer_support
    $supportCheck = $db->prepare("SELECT email FROM customer_support WHERE email = ?");
    $supportCheck->bind_param("s", $email);
    $supportCheck->execute();
    $supportResult = $supportCheck->get_result();
    
    if ($supportResult->num_rows === 1) {
        // Email exists in customer_support, insert reply
        $insertReply = $db->prepare("INSERT INTO replies (comment_id, email, reply) VALUES (?, ?, ?)");
        $insertReply->bind_param("iss", $commentId, $email, $reply);
        $insertReply->execute();
        echo "Reply posted successfully.";
    } else {
        echo "Email not recognized or not allowed to reply.";
    }
}

// Check if the form for posting a new comment has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    postComment($db, $email, $comment);
}

// Check if the form for posting a new reply has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply'])) {
    $email = $_POST['email'];
    $commentId = $_POST['comment_id'];
    $reply = $_POST['reply'];
    postReply($db, $email, $commentId, $reply);
}

// Always close the database connection
$db->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comment and Reply System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white; /* White background for the page */
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .comment, .reply {
            background-color: #f9f9f9; /* Light grey background */
            padding: 10px;
            border-radius: 5px;
            border-left: 3px solid #4CAF50; /* Green border on the left */
            margin-bottom: 10px;
        }
        .reply {
            background-color: #e9e9e9; /* Slightly darker background for replies */
            margin-left: 40px;
            border-left-color: #3e8e41; /* Darker green border for replies */
        }
        form {
            text-align: center; /* Center form content */
            margin-bottom: 20px;
        }
        input[type="email"],
        input[type="number"],
        textarea {
            width: 90%;
            margin-bottom: 10px; /* Space between inputs */
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #4CAF50; /* Green background for buttons */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block; /* Center the button */
            margin: 10px auto; /* Auto margins for horizontal centering */
        }
        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
        h2 {
            color: #4CAF50; /* Green color for headers */
        }
        #comments {
            margin-top: auto; /* Push comments to the bottom */
        }
    </style>
</head>
<body>

<div id="input-section">
    <!-- Form for posting a comment -->
    <h2>Post a Comment</h2>
    <form method="post" action="comment.php">
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="comment" placeholder="Your Comment" required></textarea>
        <button type="submit">Post Comment</button>
    </form>
    
    <!-- Form for posting a reply -->
    <h2>Post a Reply</h2>
    <form method="post" action="comment.php">
        <input type="email" name="email" placeholder="Your Support Email" required>
        <input type="number" name="comment_id" placeholder="Comment ID" required>
        <textarea name="reply" placeholder="Your Reply" required></textarea>
        <button type="submit">Post Reply</button>
    </form>
</div>

<div id="comments">
    <h2>Comments</h2>
    <?php
    // Re-establish database connection to fetch comments
    $db = new mysqli($servername, $username, $password, $dbname);
    displayCommentsAndReplies($db);
    $db->close();
    ?>
</div>

</body>
</html>

