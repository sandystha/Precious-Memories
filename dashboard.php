<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
$stmt = $pdo->prepare("SELECT username FROM admin_users WHERE admin_id = :admin_id");
$stmt->execute(['admin_id' => $admin_id]);
$admin = $stmt->fetch();

$portfolioItems = $pdo->query("SELECT * FROM portfolio")->fetchAll();
$galleryItems = $pdo->query("SELECT * FROM gallery")->fetchAll();
$contactMessages = $pdo->query("SELECT * FROM contact_messages")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e09, #d0e);
            color: #fff;
            font-family: Arial, sans-serif;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        .card {
            background-color: #333;
            border: none;
            color: #fff;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #444;
            border-bottom: 2px solid #555;
            font-weight: bold;
        }
        .alert {
            background-color: #28a745;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <!-- Success Message -->
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success text-center">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <!-- Welcome Message -->
        <h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($admin['username']); ?>!</h2>

        <!-- Portfolio Items Table -->
        <div class="card">
            <div class="card-header">Portfolio Items</div>
            <div class="card-body">
                <a href="add_portfolio.php" class="btn btn-primary mb-3">Add Portfolio Item</a>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Image URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($portfolioItems as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['title']); ?></td>
                                <td><?php echo htmlspecialchars($item['description']); ?></td>
                                <td><?php echo htmlspecialchars($item['category']); ?></td>
                                <td><a href="<?php echo htmlspecialchars($item['image_url']); ?>" target="_blank" class="text-white">View Image</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Gallery Images Table -->
        <div class="card">
            <div class="card-header">Gallery Images</div>
            <div class="card-body">
                <!-- Optional Add Gallery Button (remove if not needed) -->
                <a href="add_gallery.php" class="btn btn-primary mb-3">Add Gallery Image</a>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Uploaded At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($galleryItems as $image): ?>
                            <tr>
                                <td><img src="<?php echo htmlspecialchars($image['image_url']); ?>" width="100" alt="Gallery Image"></td>
                                <td><?php echo htmlspecialchars($image['category']); ?></td>
                                <td><?php echo htmlspecialchars($image['uploaded_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Contact Messages Table -->
        <div class="card">
            <div class="card-header">Contact Messages</div>
            <div class="card-body">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contactMessages as $message): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['name']); ?></td>
                                <td><?php echo htmlspecialchars($message['email']); ?></td>
                                <td><?php echo htmlspecialchars($message['subject']); ?></td>
                                <td><?php echo htmlspecialchars($message['message']); ?></td>
                                <td><?php echo htmlspecialchars($message['submitted_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center p-3 mt-5">
        &copy; 2024 Precious Memories Photography. All rights reserved.
    </footer>
</body>
</html>
