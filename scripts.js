document.addEventListener("DOMContentLoaded", function() {
    // Fetch articles on page load
    fetchArticles();
    
    // Add event listener to the "Add New Article" button
    const addArticleBtn = document.getElementById("addArticleBtn");
    addArticleBtn.addEventListener("click", function() {
        createNewArticle();
    });
});

function fetchArticles() {
    // Fetch articles from the server
    fetch("get_articles.php")
    .then(response => response.json())
    .then(articles => {
        const articlesContainer = document.getElementById("articles");
        articlesContainer.innerHTML = "";
        articles.forEach(article => {
            const articleElement = createArticleElement(article);
            articlesContainer.appendChild(articleElement);
        });
    });
}

function createArticleElement(article) {
    // Create a new element to represent the article
    const articleElement = document.createElement("div");
    articleElement.classList.add("article");
    articleElement.innerHTML = `
        <h2>${article.title}</h2>
        <p>Author: ${article.author}</p>
        <p>Date: ${article.post_date}</p>
        <p>Category: ${article.category}</p>
        <img src="${article.image_url}" alt="Article Image" style="max-width: 100%; height: auto;">
        <p>${article.content}</p>
        <div class="btn-group">
            <button onclick="editArticle(${article.id})">Edit</button>
            <button onclick="deleteArticle(${article.id})">Delete</button>
        </div>
    `;
    return articleElement;
}

function createNewArticle() {
    // Define the data for the new article
    const newArticleData = {
        title: "New Article",
        author: "Your Name",
        post_date: new Date().toISOString().split('T')[0],
        category: "General",
        image_url: "https://via.placeholder.com/150",
        content: "This is a new article. Write your content here."
    };

    // Send a POST request to create the new article
    fetch("create_article.php", {
        method: "POST",
        body: JSON.stringify(newArticleData),
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => response.text())
    .then(message => {
        alert(message);
        // After creating a new article, fetch articles again to update the list
        fetchArticles();
    });
}

function editArticle(articleId) {
    // Redirect to the edit article page with the article ID
    window.location.href = `edit_article.php?id=${articleId}`;
}

function deleteArticle(articleId) {
    // Send a DELETE request to delete the article
    if (confirm("Are you sure you want to delete this article?")) {
        fetch(`delete_article.php?id=${articleId}`, {
            method: "DELETE"
        })
        .then(response => response.text())
        .then(message => {
            alert(message);
            // After deleting the article, fetch articles again to update the list
            fetchArticles();
        });
    }
}