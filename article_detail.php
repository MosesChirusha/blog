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

// Get article ID from URL
$article_id = $_GET['id'];

// Fetch article details
$sql = "SELECT * FROM articles WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

// Fetch comments
$sql_comments = "SELECT * FROM comments WHERE article_id = ? ORDER BY created_at DESC";
$stmt_comments = $conn->prepare($sql_comments);
$stmt_comments->bind_param("i", $article_id);
$stmt_comments->execute();
$comments_result = $stmt_comments->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article['title']; ?></title>
</head>
<body>

    <h1><?php echo $article['title']; ?></h1>
    <img src="<?php echo $article['cover_image']; ?>" alt="Cover Image" style="width:400px; height:auto;"><br>
    <p><strong>Date:</strong> <?php echo $article['created_at']; ?></p>
    <p><?php echo nl2br($article['content']); ?></p>
    <p><strong>Likes:</strong> <?php echo $article['likes']; ?></p>
    

    <!-- Like button logic -->
    <?php
    if (isset($_COOKIE['liked_' . $article['id']])) {
        echo "<p>You have already liked this article.</p>";
    } else {
        echo "<button type='button' onclick='likeArticle(" . $article["id"] . ")'>Like</button>";
    }
    ?>

    <hr>
    <h2>Comments</h2>

    <!-- Comment Form -->
    <form action="submit_comment.php" method="POST">
        <input type="hidden" name="article_id" value="<?php echo $article['id']; ?>">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="comment">Your Comment:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" value="Submit Comment">
    </form>

    <!-- Display Comments -->
    <?php
    if ($comments_result->num_rows > 0) {
        while($comment = $comments_result->fetch_assoc()) {
            echo "<p><strong>" . $comment["name"] . ":</strong> " . $comment["comment"] . "</p>";
            echo "<p><small>Posted on: " . $comment["created_at"] . "</small></p><hr>";
        }
    } else {
        echo "<p>No comments yet. Be the first to comment!</p>";
    }

    $conn->close();
    ?>

    <script>
        function likeArticle(articleId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "like_article.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    location.reload();
                }
            };
            xhr.send("article_id=" + articleId);
        }
    </script>

</body>
</html>
