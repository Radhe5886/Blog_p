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
$user_stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_row = $user_result->fetch_assoc();
$username = $user_row['username']; // Fetch the username

// Fetch user posts including tags, ordered by created_at descending
$post_stmt = $conn->prepare("SELECT id, title, content, status, tags FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$post_stmt->bind_param("i", $user_id);
$post_stmt->execute();
$post_result = $post_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
               <a href="#" class="active">Dashboard</a>
               <a href="create_post.php">Create New Post</a>
               <a href="#">Comment</a>
             </div>
            </div>

            <div class="app-header-actions">
                <div class="user-profile-dropdown">
                    <button class="user-profile" onclick="toggleDropdown()">
                        <span><?php echo htmlspecialchars($username); ?></span> <!-- Dynamic username -->
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

        <ul>
            <?php while ($row = $post_result->fetch_assoc()) { ?>
                <li>
                    <h3><?php echo htmlspecialchars($row['title']); ?> (<?php echo htmlspecialchars($row['status']); ?>)</h3>
                    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    <strong>Tags: </strong> <?php echo htmlspecialchars($row['tags']); ?><br><br>
                    <button class="custom-btn btn-3"><a href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a></button> |
                    <button class="custom-btn btn-3"><a href="delete_post.php?id=<?php echo $row['id']; ?>">Delete</a></button>
                </li>
            <?php } ?>
        </ul>
    </div>

    <script>
        // Toggle the dropdown visibility
        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.user-profile')) {
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

<?php
// Close statements and connection
$post_stmt->close();
$user_stmt->close();
$conn->close();
?>
