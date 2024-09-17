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
    $name = $_POST['name'];
    $comment = $_POST['comment'];

    // Insert comment into the database
    $stmt = $conn->prepare("INSERT INTO comments (article_id, name, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $article_id, $name, $comment);

    if ($stmt->execute()) {
        echo "Comment submitted successfully!";
        header("Location: article_detail.php?id=" . $article_id);
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
