<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vmrs_website"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  echo "Connected to database successfully!";
}
// Start the session to keep track of logged-in user
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to check for matching email and password
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user exists with the provided email
    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a session
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['user_email'] = $user['email']; // Store email in session

            // Redirect to the dashboard or a logged-in page
            header("Location: index.html");
            exit();
        } else {
            $error_message = "Invalid email or password. ";

        }
    } else {
        $error_message = "Invalid email or password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Display error message if any -->
    <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

</body>
</html>