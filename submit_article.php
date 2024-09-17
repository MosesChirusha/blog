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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author = $_POST['author'];
    $title = $_POST['title'];
    $content =  $_POST['content'];

    // Handle file upload for the cover image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["cover_image"]["name"]);
    move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file);

    // Insert the article into the database
    $stmt = $conn->prepare("INSERT INTO articles (title, author, cover_image, content) VALUES (?, ?, ?,?)");
    $stmt->bind_param("ssss", $title, $author, $target_file, $content);

    if ($stmt->execute()) {
        echo "Article submitted successfully!";
        header("Location: articles_list.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
