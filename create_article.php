<?php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "blog"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from POST request
$title = $_POST['title'];
$author = $_POST['author'];
$post_date = date("Y-m-d", strtotime($_POST['post_date']));
$category = $_POST['category'];
$image_url = $_POST['image_url'];
$content = $_POST['content'];

// Prepare SQL statement
$sql = "INSERT INTO articles (title, author, post_date, category, image_url, content) VALUES ('$title', '$author', '$post_date', '$category', '$image_url', '$content')";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    echo "New article created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>