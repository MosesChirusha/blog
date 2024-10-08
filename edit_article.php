<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
    <!-- Include Global Navigation and Styling here -->
</head>
<body>

    <div class="container content-container">
        <h2 class="text-center">Edit Article</h2>

        <?php
        // Fetch article data by ID
        $article_id = $_GET['id'];
        $article = $conn->query("SELECT * FROM articles WHERE id = $article_id")->fetch_assoc();
        ?>

        <!-- Form for Editing the Article -->
        <div class="container form-container">
            <form action="update_article.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="author">Author Name</label>
                    <input type="text" class="form-control" id="author" name="author" value="<?php echo $article['author']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="title">Article Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $article['title']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="cover_image">Cover Image</label>
                    <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                    <p>Current image: <img src="<?php echo $article['cover_image']; ?>" alt="Cover Image" style="width: 100px; height: 100px;"></p>
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" class="form-control" rows="6" required><?php echo $article['content']; ?></textarea>
                </div>

                <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
                <button type="submit" class="btn btn-primary">Update Article</button>
            </form>
        </div>

    </div>

    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');  // Initialize CKEditor for rich text input
    </script>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 My Blog. All Rights Reserved.</p>
    </footer>
</body>
</html>
