<?php
// Database connection details
$host = "localhost"; // Database host
$db_user = "root"; // Database username
$db_pass = ""; // Database password
$db_name = "student_portal"; // Database name

// Create connection
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a session started and student ID is stored in the session
session_start();
$student_id = $_SESSION['student_id'];

// Fetch student details from the database
$sql = "SELECT * FROM students_details WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Close the connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Student Profile</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Student Details</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Student ID</th>
                            <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                        </tr>
                        <tr>
                            <th>Roll Number</th>
                            <td><?php echo htmlspecialchars($student['roll_number']); ?></td>
                        </tr>
                        <tr>
                            <th>Student Name</th>
                            <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Course Name</th>
                            <td><?php echo htmlspecialchars($student['course_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Semester</th>
                            <td><?php echo htmlspecialchars($student['semester']); ?></td>
                        </tr>
                        <tr>
                            <th>Date of Joining</th>
                            <td><?php echo htmlspecialchars($student['date_of_joining']); ?></td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td><?php echo htmlspecialchars($student['date_of_birth']); ?></td>
                        </tr>
                        <tr>
                            <th>Sex</th>
                            <td><?php echo htmlspecialchars($student['sex']); ?></td>
                        </tr>
                        <tr>
                            <th>Blood Group</th>
                            <td><?php echo htmlspecialchars($student['blood_group']); ?></td>
                        </tr>
                        <tr>
                            <th>Place of Birth</th>
                            <td><?php echo htmlspecialchars($student['place_of_birth']); ?></td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td><?php echo htmlspecialchars($student['department']); ?></td>
                        </tr>
                        <tr>
                            <th>Supervisor</th>
                            <td><?php echo htmlspecialchars($student['supervisor']); ?></td>
                        </tr>
                        <tr>
                            <th>College Email</th>
                            <td><?php echo htmlspecialchars($student['college_email']); ?></td>
                        </tr>
                        <tr>
                            <th>Branch Name</th>
                            <td><?php echo htmlspecialchars($student['branch_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Bank Name</th>
                            <td><?php echo htmlspecialchars($student['bank_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Bank Account No</th>
                            <td><?php echo htmlspecialchars($student['bank_account_no']); ?></td>
                        </tr>
                        <tr>
                            <th>Person Type</th>
                            <td><?php echo htmlspecialchars($student['person_type']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
