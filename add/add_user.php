<?php
include 'db.php';

$username = "testuser";
$password = password_hash("password123", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$stmt->close();

echo "User added successfully!";
$conn->close();
