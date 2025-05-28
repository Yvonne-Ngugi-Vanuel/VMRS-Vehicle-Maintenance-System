<?php
// Database connection
$host = 'localhost';
$db = 'vmrs_website'; //  database name
$user = 'root'; //  MySQL username
$pass = ''; //  MySQL password
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Validate passwords
    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $sql = "INSERT INTO users ( email, password) VALUES ( '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Sign-up successful! You can now <a href='login.html'>log in</a>.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
