<?php
session_start();

// Include your database connection file
require_once 'db.php';

// Get student register number from session (assuming it's stored there)
$student_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : null;

// Initialize attendance array
$attendance_data = [];

if ($student_id !== null) {
    // Fetch attendance data from the database
    $sql_attendance = "SELECT 
        SubjectCode, 
        SubjectName, 
        PresentCount, 
        AbsentCount, 
        TotalPeriods 
        FROM Attendance WHERE student_id = ?";

    $stmt_attendance = $conn->prepare($sql_attendance);
    $stmt_attendance->bind_param("s", $student_id);
    $stmt_attendance->execute();
    $result_attendance = $stmt_attendance->get_result();
    $attendance_data = $result_attendance->fetch_all(MYSQLI_ASSOC);
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject-wise Attendance</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background-color: #2c3e50;
            color: white;
            width: 250px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            margin-top: 0;
            text-align: center;
            font-size: 24px;
        }

        .nav-item {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            margin-bottom: 10px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .nav-item:hover {
            background-color: #34495e;
        }

        /* Main Content */
        .main {
            flex: 1;
            background-color: #ffffff;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            margin: 20px;
            border-radius: 8px;
        }

        .main h3 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #3498db;
        }

        /* Attendance Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Progress Bar for Attendance Percentage */
        .progress-bar {
            background-color: #f2f2f2;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            height: 20px;
        }

        .progress {
            background-color: #2ecc71;
            height: 100%;
            width: 0;
            transition: width 0.5s ease;
            text-align: center;
            color: white;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 0;
        }

        /* Back Button Styling */
        .back-button {
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #2980b9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                text-align: center;
            }

            .main {
                margin: 10px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Main Section -->
    <div class="main">
        <!-- Back Button -->
        <button class="back-button" onclick="window.history.back();">Back</button>

        <!-- Attendance Section -->
        <h3>Subject-wise Attendance</h3>
        <?php if (!empty($attendance_data)): ?>
            <table>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Present Count</th>
                    <th>Absent Count</th>
                    <th>Total Periods</th>
                    <th>Attendance Percentage</th>
                </tr>
                <?php foreach ($attendance_data as $attendance): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($attendance['SubjectCode']); ?></td>
                        <td><?php echo htmlspecialchars($attendance['SubjectName']); ?></td>
                        <td><?php echo htmlspecialchars($attendance['PresentCount']); ?></td>
                        <td><?php echo htmlspecialchars($attendance['AbsentCount']); ?></td>
                        <td><?php echo htmlspecialchars($attendance['TotalPeriods']); ?></td>
                        <td>
                            <?php 
                            $percentage = ($attendance['TotalPeriods'] > 0) 
                                ? ($attendance['PresentCount'] / $attendance['TotalPeriods']) * 100 
                                : 0;
                            ?>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo number_format($percentage, 2); ?>%">
                                    <?php echo number_format($percentage, 2) . '%'; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No attendance data available.</p>
        <?php endif; ?>
    </div>
</div>

<footer>
    &copy; 2024 Student Portal
</footer>

</body>
</html>
