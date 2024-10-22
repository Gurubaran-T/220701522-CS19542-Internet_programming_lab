<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'student_portal');

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM students WHERE email='$email' AND password='$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $_SESSION['student_id'] = $student['id'];
    $_SESSION['student_name'] = $student['name'];
    $_SESSION['student_email'] = $student['email'];
    $_SESSION['student_course'] = $student['course'];
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
}
?>
