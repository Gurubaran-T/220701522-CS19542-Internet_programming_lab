<?php
// Database configuration
$servername = "localhost"; // Database server (usually localhost)
$username = "root";        // Database username
$password = "";            // Database password (leave empty if no password)
$dbname = "student_portal"; // Name of the database

// Create a new connection to the MySQL database using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the charset to ensure proper handling of special characters
$conn->set_charset("utf8");

// The connection is now available to use
?>
