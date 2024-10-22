<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection (replace with your connection details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_SESSION['student_id'];

// Handle AJAX request to fetch notifications
if (isset($_POST['fetch_notifications'])) {
    // Debugging: Check the student_id
    if (!$student_id) {
        echo '<p>Student ID not set.</p>';
        exit();
    }

    $sql = "SELECT time, message FROM notifications WHERE student_id = ? ORDER BY time DESC"; // Ensure correct ordering
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo '<p>SQL Prepare Error: ' . htmlspecialchars($conn->error) . '</p>';
        exit();
    }

    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debugging: Check if notifications are retrieved
    if ($result === false) {
        echo '<p>Error executing query: ' . htmlspecialchars($stmt->error) . '</p>';
        exit();
    }

    if ($result->num_rows > 0) {
        echo '<section class="notification-box">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="notification"><strong>' . htmlspecialchars($row['time']) . ':</strong> ' . htmlspecialchars($row['message']) . '</div>';
        }
        echo '</section>';
    } else {
        echo '<p>No notifications available.</p>';
    }

    $stmt->close();
    exit(); // Exit to prevent further output after AJAX response
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #f0f4f8, #e0e7ea);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 700px;
            width: 100%;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .notifications {
            margin-top: 20px;
        }

        section.notification-box {
            padding: 10px; /* Increased padding for a larger box */
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); /* Deeper shadow */
            background-color: #f9f9f9;
            max-width: 100%;
        }

        .notification {
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
            background-color: #e6f7ff;
            border-left: 5px solid #007bff;
            transition: background-color 0.3s ease;
        }

        .notification:hover {
            background-color: #d4f1ff;
        }

        .notification strong {
            display: inline-block;
            width: 120px;
            color: #0056b3;
        }

        .back-button {
            display: inline-block;
            padding: 12px 25px; /* Increased button size */
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .back-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .loading {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #555;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 0.9em;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container">
    <button onclick="window.location.href='dashboard.php'" class="back-button">Back</button>
    <div class="main">
        <h3>Notifications</h3>
        <div class="notifications" id="notifications">
            <p class="loading">Loading notifications...</p> <!-- Loading indicator -->
        </div>
    </div>
</div>

<script>
    // Function to fetch notifications using AJAX
function loadNotifications() {
    $.ajax({
        url: 'notifications.php', // Same file handles both page and AJAX requests
        type: 'POST',
        data: { fetch_notifications: true },
        success: function(response) {
            console.log(response); // Log the response
            $('#notifications').html(response);
        },
        error: function() {
            $('#notifications').html('<p>Error loading notifications.</p>');
        }
    });
}

// Load notifications when the page is ready
$(document).ready(function() {
    loadNotifications();
});

</script>

</body>
</html>
