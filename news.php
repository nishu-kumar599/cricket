<!doctype html>
<html lang="en">

<head>
    <?php require 'head.php'; ?>
</head>
<style>
    .sports-news {
        background: none !important;
    }
</style>

<body>
    <!-- Header -->
    <?php require 'header.php'; ?>
    <div class="container">
        <section class="wf100 p80 sports-news">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2>News & Media Gallery</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                    include 'db_connection.php';
                    // Fetch the latest three blog entries
                    $stmt = $conn->prepare("SELECT id, title, description, editor, image, created_at FROM blog ORDER BY created_at");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $title = $row['title']; // Assume HTML safe or sanitize elsewhere if needed.
                        $description = $row['description']; // Output HTML content directly.
                        $editor = $row['editor'];
                        $image = $row['image'];
                        $created_at = date("M d, Y", strtotime($row['created_at']));
                        $imagePath = $image ? "../images/blog_images/{$image}" : 'path_to_default_image.jpg';
                        ?>
                        <div class="col-lg-12">
                            <div class="news-list-post">
                                <div class="post-thumb">
                                    <a href="news_detail.php?id=<?php echo $id; ?>"><i class="fas fa-link"></i></a>
                                    <img src="<?php echo $imagePath; ?>"
                                        alt="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"
                                        class="img-fluid">
                                </div>
                                <div class="post-txt">
                                    <ul class="post-author">
                                        <li><img src="images/user1.jpg" alt="">
                                            <strong><?php echo htmlspecialchars($editor, ENT_QUOTES, 'UTF-8'); ?></strong>
                                        </li>
                                    </ul>
                                    <h4><a
                                            href="news_detail.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></a>
                                    </h4>
                                    <ul class="post-meta">
                                        <li><i class="fas fa-calendar-alt"></i> <?php echo $created_at; ?></li>
                                    </ul>
                                    <p><?php echo $description; ?></p> <!-- Render HTML from description -->
                                    <a href="news_detail.php?id=<?php echo $id; ?>" class="rm">Read More</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    $stmt->close();
                    ?>
                </div>
            </div>
        </section>

    </div>
    <!-- Footer -->
    <?php require 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>