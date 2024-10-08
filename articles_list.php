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

// Fetch articles from the database
$sql = "SELECT id, title, cover_image, content, created_at, likes FROM articles ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
</head>
<body>

    <h1>All Articles</h1>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h2>" . $row["title"] . "</h2>";
            echo "<img src='" . $row["cover_image"] . "' alt='Cover Image' style='width:200px; height:auto;'><br>";
            echo "<p><strong>Date:</strong> " . $row["created_at"] . "</p>";
            echo "<p>" . substr(nl2br($row["content"]), 0, 200) . "...</p>";  // Preview
            echo "<p>Likes: " . $row["likes"] . "</p>";

            // Check if this article has been liked by this device
            $article_id = $row["id"];
            if (isset($_COOKIE['liked_' . $article_id])) {
                echo "<p>You have already liked this article.</p>";
            } else {
                echo "<button type='button' onclick='likeArticle(" . $row["id"] . ")'>Like</button>";
            }

            echo "<a href='article_detail.php?id=" . $row["id"] . "'>Read More</a><br>";
            echo "<a href='article_detail.php?id=" . $row["id"] . "#comments'>Comment</a>";
            echo "</div><hr>";
            
        }
    } else {
        echo "No articles found.";
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
                    location.reload();  // Refresh the page after liking
                }
            };
            xhr.send("article_id=" + articleId);
        }
    </script>

</body>
</html>
