<?php
require 'db_connect.php';

$username = 'sandip';
$password = password_hash('sandip120', PASSWORD_BCRYPT); // Choose a secure password
$email = 'psth117@gmail.com.com';

$stmt = $pdo->prepare("INSERT INTO admin_users (username, password, email) VALUES (:username, :password, :email)");
$stmt->execute(['username' => $username, 'password' => $password, 'email' => $email]);

echo "Admin user created successfully.";
?>
