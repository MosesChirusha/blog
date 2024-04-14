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

// Retrieve articles from database
$sql = "SELECT * FROM articles";
$result = $conn->query($sql);

// Fetch and output articles as JSON
$articles = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
    echo json_encode($articles);
} else {
    echo "0 results";
}

$conn->close();
?>