<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];

    // Move the uploaded file to the images directory
    move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image);

    // Insert the new portfolio item into the database
    $stmt = $pdo->prepare("INSERT INTO portfolio (title, image) VALUES (:title, :image)");
    $stmt->execute(['title' => $title, 'image' => $image]);

    echo "Portfolio item added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Portfolio Item</title>
</head>
<body>
    <h2>Add New Portfolio Item</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="image">Image</label>
        <input type="file" id="image" name="image" required>
        <br>
        <button type="submit">Add Portfolio Item</button>
    </form>
</body>
</html>
