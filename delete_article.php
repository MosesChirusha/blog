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

// Retrieve article ID from GET request
$id = $_GET['id'];

// Prepare SQL statement
$sql = "DELETE FROM articles WHERE id=$id";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    echo "Article deleted successfully";
} else {
    echo "Error deleting article: " . $conn->error;
}

$conn->close();
?>