<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Landing Page</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS for styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            padding-top: 70px;
        }

        .carousel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .article-list {
            margin-top: 30px;
        }

        .article-list h4 {
            margin-bottom: 15px;
        }

        .article-list-item {
            margin-bottom: 10px;
        }

        .article-list-item a {
            color: #007bff;
            text-decoration: none;
        }

        .article-list-item a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">My Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="new_article.php">Add Article</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Carousel for Latest Articles -->
    <div id="latestArticlesCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php

            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "blog";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Fetch the 3 latest articles from the database
            $articles = $conn->query("SELECT * FROM articles ORDER BY created_at DESC LIMIT 3");
            $isActive = true;

            while($article = $articles->fetch_assoc()) {
                echo '<div class="carousel-item ' . ($isActive ? 'active' : '') . '">';
                echo '<img src="' . $article['cover_image'] . '" alt="Article Image">';
                echo '<div class="carousel-caption d-none d-md-block">';
                echo '<h5>' . $article['title'] . '</h5>';
                echo '<p>' . substr($article['content'], 0, 100) . '...</p>';
                echo '</div>';
                echo '</div>';
                $isActive = false;
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#latestArticlesCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#latestArticlesCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="container article-list">
    <h4>Top 5 Articles</h4>
    <div class="list-group">
        <?php
        // Fetch the top 5 articles from the database
         $topArticles = $conn->query("
            SELECT articles.id, articles.title, articles.content, articles.cover_image, articles.created_at, articles.likes, articles.author, 
            (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comment_count 
            FROM articles 
            ORDER BY likes DESC LIMIT 5
        ");

        while ($article = $topArticles->fetch_assoc()) {
            // Calculate time ago
            $created_at = new DateTime($article['created_at']);
            $now = new DateTime();
            $interval = $now->diff($created_at);
            
            if ($interval->y > 0) {
                $time_ago = $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
            } elseif ($interval->m > 0) {
                $time_ago = $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
            } elseif ($interval->d > 0) {
                $time_ago = $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
            } elseif ($interval->h > 0) {
                $time_ago = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
            } else {
                $time_ago = $interval->i . ' min ago';
            }
            ?>
            
            <div class="list-group-item article-list-item">
                <div class="media">
                    <img src="<?php echo $article['cover_image']; ?>" class="mr-3" alt="Article Image" style="width: 100px; height: 100px; object-fit: cover;">
                    <div class="media-body">
                        <h5 class="mt-0">
                            <a href="article_detail.php?id=<?php echo $article['id']; ?>"><?php echo $article['title']; ?></a>
                        </h5>
                        <p>
                            <?php echo substr(strip_tags($article['content']), 0, 100); ?>...
                        </p>
                        <small class="text-muted">
                            By <?php echo $article['author']; ?> | <?php echo $time_ago; ?> | <?php echo $article['comment_count']; ?> Comments
                        </small>
                    </div>
                </div>
            </div>
            
            <?php
        }
        ?>
    </div>
</div>


    <!-- Footer -->
    <footer>
        <p>&copy; 2024 My Blog. All Rights Reserved.</p>
    </footer>

    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
