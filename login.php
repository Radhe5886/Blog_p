<?php
session_start();

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
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Prepare statement to fetch user
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();
        
        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: dashboard.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
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
    <title>Login</title>
    <link rel="stylesheet" href="c2.css">
    <style>
        .id-pass{
width: 300px;
.button-l{
    margin-left: 10px;
}
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="nav">
    <ul>
        <a><span class="blue-logo"></span> Your Personal Blog<span class="blue">.</span></a>
        <a class="gray" href="index.php">Home</a>
        
    </ul>
</div>
<div class="hero">
    <div class="text">
        <p class="gray">START FOR FREE</p>
        <h1> Login <span class="blue">.</span></h1>
        <p  class="gray">Not Having Account ? <span class="blue" onclick="location.href='signup_form.php'">Create Account</span></p>
    </div>
    <form action="login.php" method="POST">
        <div class="name">
            <div class="input-icons">
                <legend for="first">Username <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                        <path
                            d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" />
                    </svg></legend>
                <div class="icon-center">
                    <input class="input" type="text" id="username" name="username" required>
                    
                </div>
            </div>
            
        </div>
        <div class="id-pass" >
        <div class="input-icons">
            <legend for="password">Password  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-eye-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                    <path
                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                </svg></legend>
            <div class="icon-center">
                <input class="input" type="password" id="password" name="password" required>
               
            </div>
        </div>
    </div>
    <div class="buttons-l">
            
        <button type="submit" value="login" class="btn blue-btn">login</button>
    </div>

    </form>
</div>
</div>
</body>
</html>

