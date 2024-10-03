<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog_platform";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $tags = $conn->real_escape_string($_POST['tags']);
    $user_id = $_SESSION['user_id'];

    // Save as draft
    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, tags, status) VALUES (?, ?, ?, ?, 'draft') ON DUPLICATE KEY UPDATE title = VALUES(title), content = VALUES(content), tags = VALUES(tags), updated_at = CURRENT_TIMESTAMP");
    $stmt->bind_param("isss", $user_id, $title, $content, $tags);

    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>
