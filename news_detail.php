<?php
session_start();
require 'db_connection.php';

// Get the news ID from the URL parameter
$news_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the news data from the database
if ($news_id > 0) {
    $stmt = $conn->prepare("SELECT id, title, description, editor, image, created_at FROM blog WHERE id = ?");
    $stmt->bind_param("i", $news_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $news = $result->fetch_assoc();
} else {
    echo "Invalid News ID";
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <?php require 'head.php'; ?>
    <title><?php echo htmlspecialchars($news['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .blog .img-fluid {
        max-width: 100%;
        height: auto;
        width: -webkit-fill-available;
    }

    .blog .lead {
        font-size: 1.25rem;
        font-weight: 300;
    }

    .blog .rounded {
        border-radius: 0.75rem;
    }

    .blog hr {
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, .1);
    }

    .blog .bg-light {
        background-color: #f8f9fa !important;
    }
</style>

<body>
    <!-- Header -->
    <?php require 'header.php'; ?>

    <main class="py-5 blog">
        <div class="container">
            <!-- News Article -->
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!-- Article content -->
                    <article>
                        <h1 class="mb-3 mt-5"><?php echo htmlspecialchars($news['title']); ?></h1>
                        <p class="meta">Published on <?php echo date("F j, Y", strtotime($news['created_at'])); ?>
                        </p>
                        <p>Editor:<?php echo htmlspecialchars($news['editor']); ?></p>
                        <img src="<?php echo $news['image'] ? "../images/blog_images/" . htmlspecialchars($news['image']) : 'path_to_default_image.jpg'; ?>"
                            class="img-fluid mb-3" alt="<?php echo htmlspecialchars($news['title']); ?>">
                        <div>
                            <h3>Description:</h3>
                            <br>
                            <p><?php echo $news['description']; ?></p> <!-- Correctly display the description -->
                        </div>
                    </article>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php require 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>