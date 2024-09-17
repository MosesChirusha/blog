<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $article_id = $_POST['article_id'];

    // Check if the user has already liked this article using a cookie
    if (isset($_COOKIE['liked_' . $article_id])) {
        echo "You have already liked this article.";
    } else {
        // Increment the like count in the database
        $stmt = $conn->prepare("UPDATE articles SET likes = likes + 1 WHERE id = ?");
        $stmt->bind_param("i", $article_id);

        if ($stmt->execute()) {
            // Set a cookie to remember that this device liked the article
            setcookie('liked_' . $article_id, true, time() + (86400 * 365));  // Expires in 1 year
            echo "Thank you for liking the article!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
