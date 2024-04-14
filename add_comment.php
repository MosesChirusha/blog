<?php
$servername = "localhost";
$username = "username"; // Your MySQL username
$password = "password"; // Your MySQL password
$dbname = "blog"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from POST request
$article_id = $_POST['article_id'];
$author = $_POST['author'];
$comment = $_POST['comment'];

// Prepare SQL statement
$sql = "INSERT INTO comments (article_id, author, comment) VALUES ('$article_id', '$author', '$comment')";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    echo "New comment added successfully";
} else {
    echo "Error adding comment: " . $conn->error;
}

$conn->close();
?>