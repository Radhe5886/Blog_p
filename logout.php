<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page or home page
header("Location: login.php"); // Change this to your desired page
exit();
?>
