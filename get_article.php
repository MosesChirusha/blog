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

// Fetch article from database
$sql = "SELECT * FROM articles WHERE id=$id";
$result = $conn->query($sql);

// Fetch and output article as JSON
$article = [];
if ($result->num_rows > 0) {
    $article = $result->fetch_assoc();
    echo json_encode($article);
} else {
    echo "Article not found";
}

$conn->close();
?>