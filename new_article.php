<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Article</title>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>  <!-- CKEditor CDN -->
</head>
<body>

    <h1>Submit a New Article</h1>

    <form action="submit_article.php" method="POST" enctype="multipart/form-data">
        <label for="author">Author Name:</label><br>
        <input type="text" id="author" name="author" required><br><br>

        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="cover_image">Cover Image:</label><br>
        <input type="file" id="cover_image" name="cover_image" accept="image/*" required><br><br>

        <label for="content">Article Content:</label><br>
        <textarea id="content" name="content" rows="10" cols="50" required></textarea><br><br>

        <input type="submit" value="Submit Article">
    </form>

</body>

<script>
        // Initialize CKEditor on the textarea with id 'content'
        CKEDITOR.replace('content');
    </script>

</html>