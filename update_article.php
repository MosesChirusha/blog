<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $article_id = $_POST['article_id'];
    $author = $_POST['author'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Check if new cover image was uploaded
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
        $cover_image = 'uploads/' . basename($_FILES["cover_image"]["name"]);
        move_uploaded_file($_FILES["cover_image"]["tmp_name"], $cover_image);

        // Update article with new cover image
        $update_sql = "UPDATE articles SET author = '$author', title = '$title', content = '$content', cover_image = '$cover_image' WHERE id = $article_id";
    } else {
        // Update article without changing the cover image
        $update_sql = "UPDATE articles SET author = '$author', title = '$title', content = '$content' WHERE id = $article_id";
    }

    if ($conn->query($update_sql) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error updating article: " . $conn->error;
    }
}
?>
