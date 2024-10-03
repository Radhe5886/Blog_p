<?php
session_start();
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get post ID from query string
$post_id = $_GET['id'];

// Fetch the logged-in user's username (assuming you store it in the session)
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Handle form submission for updating the post
if (isset($_POST['update_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    // Update query for the post
    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, tags = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sssii", $title, $content, $tags, $post_id, $_SESSION['user_id']);
    $stmt->execute();

    // Redirect to dashboard after update
    header("Location: dashboard.php");
    exit(); // Ensure script execution stops after the redirect
}

// Handle form submission for publishing the post
if (isset($_POST['publish_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    // Update query to publish the post
    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, tags = ?, status = 'published', updated_at = NOW() WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sssii", $title, $content, $tags, $post_id, $_SESSION['user_id']);
    $stmt->execute();

    // Redirect to the main page or dashboard after publishing
    header("Location: dashboard.php"); // Change this to your main page URL
    exit(); // Ensure script execution stops after the redirect
}

// Fetch post details
$stmt = $conn->prepare("SELECT title, content, tags FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($title, $content, $tags);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="c1.css">
</head>
<body>
    <div class="app">
        <header class="app-header">
            <div class="app-header-logo">
                <div class="logo">
                    <span class="logo-icon">
                        <img src="https://assets.codepen.io/285131/almeria-logo.svg" />
                    </span>
                    <h3 class="logo-title">
                        <span>Your Personal</span>
                        <span>Blog Post</span>
                    </h3>
                </div>
            </div>
            <div class="app-header-navigation">
                <div class="tabs">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="create_post.php">Create New Post</a>
                    <a href="#">Comment</a>
                </div>
            </div>
            <div class="app-header-actions">
                <div class="user-profile-dropdown">
                    <button class="user-profile" onclick="toggleDropdown()">
                        <span><?php echo htmlspecialchars($username); ?></span>
                        <span>
                            <img src="https://assets.codepen.io/285131/almeria-avatar.jpeg" />
                        </span>
                    </button>
                    <div class="dropdown-content" id="myDropdown">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </header><br><br>

        <form method="POST" action="edit_post.php?id=<?= htmlspecialchars($post_id); ?>">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($title); ?>" required><br><br>
            
            <label for="content">Content:</label><br>
            <textarea id="mytextarea" name="content" required><?= htmlspecialchars($content); ?></textarea><br><br>
            
            <label for="tags">Tags:</label>
            <input type="text" name="tags" value="<?= htmlspecialchars($tags); ?>"><br><br>

            <button type="submit" name="update_post" class="custom-btn btn-3"><span>Update Post</span></button>
            <button type="submit" name="publish_post" class="custom-btn btn-3"><span>Post on Site</span></button>
        </form>
    </div>

    <!-- TinyMCE Integration -->
    <script src="https://cdn.tiny.cloud/1/t116g8u9zp0u07jq1dl20hqg7r3giytdpvt3vrj13lzik74r/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea',
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media',
                'searchreplace', 'table', 'visualblocks', 'wordcount', 'checklist', 'mediaembed', 'casechange', 
                'export', 'a11ychecker', 'spellchecker'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table',
            menubar: false,
            forced_root_block: false, // Disable automatic wrapping in block elements
            valid_elements: 'strong,em,span[style]', // Allow only strong and em tags
        });

        // Toggle the dropdown visibility
        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.user-profile') && !event.target.closest('.user-profile-dropdown')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>
