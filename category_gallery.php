<?php
require 'db_connect.php';

// Get the category from the URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Prepare SQL query to fetch images by category
$stmt = $pdo->prepare("SELECT * FROM gallery WHERE category = :category ORDER BY uploaded_at DESC");
$stmt->execute(['category' => $category]);
$galleryItems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($category); ?> Gallery - Precious Memories Photography</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <h1 class="text-center"><?php echo htmlspecialchars($category); ?> Gallery</h1>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="portfolio.php">Portfolio</a></li>
                    <li class="nav-item"><a class="nav-link" href="gallery.php">All Galleries</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <?php if ($galleryItems): ?>
                <?php foreach ($galleryItems as $image): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($image['image_url']); ?>" class="card-img-top img-fluid" alt="Gallery Image">
                            <div class="card-body">
                                <p class="card-text text-center"><?php echo htmlspecialchars($image['category']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No images available for this category.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer class="bg-dark text-white text-center p-3 mt-5">
        &copy; 2024 Precious Memories Photography. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
