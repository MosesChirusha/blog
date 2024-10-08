<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $article_id = $_GET['id'];

    // Delete the article from the database
    $delete_sql = "DELETE FROM articles WHERE id = $article_id";
    
    if ($conn->query($delete_sql) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error deleting article: " . $conn->error;
    }
}
?>
