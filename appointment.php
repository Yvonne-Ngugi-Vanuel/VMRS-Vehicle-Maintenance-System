<?php
// Database connection
$servername = "localhost";
$username = "root";  // Default username for XAMPP
$password = "";  // Default password for XAMPP
$dbname = 'vmrs_appointment';  // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];

    // Insert data into the database
    $sql = "INSERT INTO appointments (name, email, date, time, message) 
            VALUES ('$name', '$email', '$date', '$time', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment scheduled successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
