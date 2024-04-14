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
$id = $_POST['id'];
$title = $_POST['title'];
$author = $_POST['author'];
$post_date = date("Y-m-d", strtotime($_POST['post_date']));
$category = $_POST['category'];
$image_url = $_POST['image_url'];
$content = $_POST['content'];

// Prepare SQL statement
$sql = "UPDATE articles SET title='$title', author='$author', post_date='$post_date', category='$category', image_url='$image_url', content='$content' WHERE id=$id";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    echo "Article updated successfully";
} else {
    echo "Error updating article: " . $conn->error;
}

$conn->close();
?>