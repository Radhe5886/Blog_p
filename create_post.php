<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
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

// Fetch the logged-in user's details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_row = $result->fetch_assoc();
$username = $user_row['username'];
$stmt->close();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $tags = $conn->real_escape_string($_POST['tags']);
    $status = isset($_POST['publish']) ? 'published' : 'draft';
    $user_id = $_SESSION['user_id'];

    // Insert the post
    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, tags, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $title, $content, $tags, $status);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <meta http-equiv="Content-Security-Policy" content="script-src 'self' https://cdn.tiny.cloud; object-src 'none';">

    <script src="https://your_server/tinymce.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/t116g8u9zp0u07jq1dl20hqg7r3giytdpvt3vrj13lzik74r/tinymce/7/plugins.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea',  // Target the textarea with id="mytextarea"
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 
                'searchreplace', 'table', 'visualblocks', 'wordcount', 'checklist', 'mediaembed', 'casechange', 
                'export', 'a11ychecker', 'spellchecker'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table',
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        setInterval(function() {
            var title = document.getElementsByName('title')[0].value;
            var content = tinymce.get('mytextarea').getContent();
            var tags = document.getElementsByName('tags')[0].value;

            $.ajax({
                type: 'POST',
                url: 'save_draft.php',
                data: { title: title, content: content, tags: tags },
                success: function(response) {
                    console.log('Draft saved');
                }
            });
        }, 30000); // Auto-save every 30 seconds
    </script>
    
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
                    <a href="create_post.php" class="active">Create New Post</a>
                    <a href="#">Comment</a>
                </div>
            </div>
            <div class="app-header-actions">
                <div class="user-profile-dropdown">
                    <button class="user-profile" onclick="toggleDropdown()">
                        <span><?php echo htmlspecialchars($username); ?></span>
                        <span>
                            <img src="https://assets.codepen.io/285131/almeria-avatar.jpeg" alt="User Avatar" />
                        </span>
                    </button>
                    <div class="dropdown-content" id="myDropdown">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </header>

        <h2>Create New Post</h2>
        <form action="" method="POST" class="content">
            <label for="title">Title: </label>
            <input type="text" name="title" required><br><br>
            <label for="tags">Tags (comma separated):</label>
            <input type="text" name="tags"><br><br>
            <label for="content">Content:</label><br>
            <textarea id="mytextarea" name="content" required></textarea><br>
            <button type="submit" name="publish" class="custom-btn btn-3"><span>Publish</span></button>
            <button type="submit" name="draft" class="custom-btn btn-3"><span>Save as Draft</span></button>
        </form>
    </div>

    <script>
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
