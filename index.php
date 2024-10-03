<?php
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

// Query to fetch all published posts along with the author's username, ordered by the latest post first
$sql = "SELECT p.title, p.content, p.tags, p.created_at, p.updated_at, u.username 
        FROM posts p 
        JOIN users u ON p.user_id = u.id 
        WHERE p.status = 'published' 
        ORDER BY p.created_at DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <style> 
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
        } 

        header { 
            background-color: #ffffff; 
            color: #000000; 
            text-align: center; 
        } 

        nav { 
            background-color: #242424; 
            padding: 10px; 
        } 

        nav a { 
            color: #fff; 
            text-decoration: none; 
            padding: 10px; 
            margin-right: 10px; 
            display: inline-block; 
        } 

        .container { 
            display: flex; 
            justify-content: space-between; 
            max-width: 95%; 
            margin: 0 auto; 
            padding: 20px; 
        } 

        article p { 
            text-align: justify; 
        } 

        main { 
            flex: 2; 
        } 

        article { 
            margin-bottom: 20px; 
            padding: 10px 20px; 
            border: 1px solid rgb(145, 145, 145); 
            margin-right: 10px; 
        } 

        aside { 
            flex: 1; 
            background-color: #c9c9c9; 
            padding: 10px; 
        } 

        footer { 
            background-color: #242424; 
            color: #fff; 
            text-align: center; 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
        } 
        .btn {
            background-color: #007BFF; /* Blue background */
            color: white; /* White text */
            padding: 12px 24px; /* Padding around the button */
            border: none; /* Remove default border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Adjust font size */
            transition: background-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effects */
        }
    </style> 
</head>
<body>
<header> 
    <h1>Blogs</h1> 
    <p>Read-Share-Gain=Knowledge.</p> 
</header>
<nav> 
    <a href="#" class="btn">Home</a> 
    <a href="signup_form.php">Signup</a> 
    <a href="login.php">Login</a> 
    
    <a href="#">Contact</a> 
</nav> 

<div class="container"> 
    <main>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <article> 
                <h2><?php echo $row['title']; ?></h2> 
                <p class="post-meta"> 
                    Published on <?php echo $row['created_at']; ?> by <?php echo $row['username']; ?>
                </p>  
                <?php if ($row['updated_at'] != $row['created_at']) { ?>
                    <p>Updated on: <?php echo $row['updated_at']; ?></p>
                <?php } ?>
                <p><?php echo nl2br($row['content']); ?></p> 
                <p><b>Tags:</b> <?php echo $row['tags']; ?></p>
            </article> 
        <?php } ?>
    </main>
</div>

<footer>
    <p>&copy; Create Your Personal Blog</p>
</footer>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
