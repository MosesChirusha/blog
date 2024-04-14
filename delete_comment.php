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

// Retrieve comment ID from GET request
$id = $_GET['id'];

// Prepare SQL statement
$sql = "DELETE FROM comments WHERE id=$id";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    echo "Comment deleted successfully";
} else {
    echo "Error deleting comment: " . $conn->error;
}

$conn->close();
?>