<?php
session_start();
require 'db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $image_url = $_POST['image_url']; // URL of the image

    // Insert the new gallery item into the database
    $stmt = $pdo->prepare("INSERT INTO gallery (image_url, category, uploaded_at) VALUES (:image_url, :category, NOW())");
    $stmt->execute(['image_url' => $image_url, 'category' => $category]);

    // Redirect back to the dashboard with a success message
    header("Location: dashboard.php?message=Gallery+Image+Added+Successfully");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Gallery Image</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Add New Gallery Image</h2>

        <!-- Form to add a new gallery image -->
        <form action="add_gallery.php" method="POST">
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" name="category" class="form-control" id="category" required placeholder="e.g., Landscape, Portrait">
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="text" name="image_url" class="form-control" id="image_url" required placeholder="Enter the URL of the image">
            </div>
            <button type="submit" class="btn btn-primary">Add Image</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
