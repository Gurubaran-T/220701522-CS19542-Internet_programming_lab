<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* CSS for layout and design */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 17%;
            background-color: #f8f8f8;
            padding: 20px;
            flex-shrink: 0;
        }

        .main {
            width: 80%;
            padding: 20px;
            flex-grow: 1;
        }

        .events, .news-boxes, .calendar-timetable, .info-boxes {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .info-box {
            flex: 1;
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .info-box h4 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .info-box p {
            font-size: 16px;
            font-weight: bold;
        }

        .student-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .student-info img {
            border-radius: 50%;
        }

        .student-name {
            font-size: 24px;
            font-weight: bold;
        }

        .cgpa {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #f1f1f1;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        #calendar {
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
            margin-top: 10px;
        }

        .calendar-row {
            display: flex;
            justify-content: space-between;
        }

        .calendar-header, .calendar-cell {
            width: calc(100% / 7);
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .header-row .calendar-header {
            font-weight: bold;
            background-color: #f4f4f4;
        }

        .calendar-cell {
            min-height: 40px;
        }

        .calendar-cell.today {
            background-color: #87CEFA;
        }

        .calendar-cell.empty {
            background-color: transparent;
        }
.university-logo img.logo {
    max-width: 100%; /* Ensures the logo does not exceed the width of its container */
    height: auto; /* Maintains the aspect ratio */
    display: block; /* Prevents any space below the image */
    margin: 0 auto; /* Centers the logo horizontally */
}

    </style>
</head>

<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['student_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Retrieve user information from session
$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];

$student_name = "Unknown Student"; 
$student_photo = "default_photo.jpg"; 
$attendance_percentage = 0; 
$leave_taken = 0;
$leave_balance = 0;
$cgpa = 0.0;

$sql = "SELECT student_name, student_photo, attendance_percentage, leave_taken, leave_balance, cgpa FROM students WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $student_name = $student['student_name'] ?: "Unknown Student";
        $student_photo = $student['student_photo'] ?: "default_photo.jpg";
        $attendance_percentage = $student['attendance_percentage'];
        $leave_taken = $student['leave_taken'];
        $leave_balance = $student['leave_balance'];
        $cgpa = $student['cgpa'];
    } else {
        $student_name = "No student data found.";
    }
} else {
    error_log("Database error: " . $stmt->error);
}

$sql = "SELECT title, content FROM news_updates ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$news = ''; // Initialize the variable to hold news content

while ($row = $result->fetch_assoc()) {
    $news .= '<strong>' . htmlspecialchars($row['title']) . ':</strong> ' . htmlspecialchars($row['content']) . '<br>';
}

// Now you can use the $news variable in your HTML output.
$sql = "SELECT title, content FROM notices ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$notices = ''; // Initialize the variable to hold notice content

while ($row = $result->fetch_assoc()) {
    $notices .= '<strong>' . htmlspecialchars($row['title']) . ':</strong> ' . htmlspecialchars($row['content']) . '<br>';
}

// Now you can use the $notices variable in your HTML output.
$sql = "SELECT title, content FROM announcements ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$announcements = ''; // Initialize the variable to hold announcement content

while ($row = $result->fetch_assoc()) {
    $announcements .= '<strong>' . htmlspecialchars($row['title']) . ':</strong> ' . htmlspecialchars($row['content']) . '<br>';
}

// Now you can use the $announcements variable in your HTML output.

?>

<body>

    <div class="container">
        <div class="sidebar">
            <div class="university-logo">
    <img src="logo.png" alt="University Logo" class="logo">
</div>

            <a href="dashboard.php" class="nav-item active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="notifications.php" class="nav-item">
                <i class="fas fa-bell"></i> Notifications
            </a>
            <a href="result.php" class="nav-item">
                <i class="fas fa-graduation-cap"></i> Result
            </a>
            <a href="calendar.php" class="nav-item">
                <i class="fas fa-calendar-alt"></i> Calendar
            </a>
            <a href="attendance.php" class="nav-item">
                <i class="fas fa-chart-bar"></i> Attendance
            </a>
           
            <a href="logout.php" class="nav-item">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>


        <div class="main">
            <!-- Display Date and Time at the top -->
            <div class="date-time" id="date-time"></div>

            <div class="card student-info">
                <div style="display: flex; align-items: center;">
                    <img src="<?php echo $student_photo; ?>" alt="Student Photo" width="100" height="100">
                    <h2 class="student-name"><?php echo $student_name; ?></h2>
                </div>
                <div class="cgpa">
                    CGPA: <strong><?php echo number_format($cgpa, 2); ?></strong>
                </div>
            </div>

            <div class="card">
                <h3>Attendance & Leave Information</h3>
                <div class="info-boxes">
                    <div class="info-box">
                        <h4>Attendance</h4>
                        <p><?php echo $attendance_percentage; ?>%</p>
                    </div>
                    <div class="info-box">
                        <h4>Leave Taken</h4>
                        <p><?php echo $leave_taken; ?> days</p>
                    </div>
                    <div class="info-box">
                        <h4>Leave Balance</h4>
                        <p><?php echo $leave_balance; ?> days</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3>Updates</h3>
                <div class="news-boxes">
                    <div class="info-box">
                        <h4>News</h4>
                        <p><?php echo $news; ?></p>
                    </div>
                    <div class="info-box">
                        <h4>Notices</h4>
                        <p><?php echo $notices; ?></p>
                    </div>
                    <div class="info-box">
                        <h4>Announcements</h4>
                        <p><?php echo $announcements; ?></p>
                    </div>
                </div>
            </div>
<div class="card">
    <h3>Events</h3>
    <div class="events">
        <div class="info-box">
            <h4>General Events</h4>
            <p>[General Events will be displayed here]</p>
            <!-- Here you can integrate the details of general events -->
        </div>
        <div class="info-box">
            <h4>Placement Events</h4>
            <p>[Placement Events will be displayed here]</p>
            <!-- Here you can integrate the details of placement events -->
        </div>
    </div>
</div>

            <div class="card">
                <h3>Calendar & Timetable</h3>
                <div class="calendar-timetable">
                    <div class="info-box">
                        <h4>Monthly Calendar</h4>
                        <div id="calendar"></div>
                    </div>
                    <div class="info-box">
                        <h4>Timetable</h4>
                        <p>[Timetable will be displayed here]</p>
                    </div>
                </div>
            </div>

            <script>
                function generateCalendar() {
                    const now = new Date();
                    const month = now.getMonth();
                    const year = now.getFullYear();
                    const firstDay = new Date(year, month, 1).getDay();
                    const daysInMonth = new Date(year, month + 1, 0).getDate();
                    const calendar = document.getElementById('calendar');
                    calendar.innerHTML = '';
                    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

                    const headerRow = document.createElement('div');
                    headerRow.className = 'calendar-row header-row';
                    dayNames.forEach(day => {
                        const dayHeader = document.createElement('div');
                        dayHeader.className = 'calendar-header';
                        dayHeader.textContent = day;
                        headerRow.appendChild(dayHeader);
                    });
                    calendar.appendChild(headerRow);

                    let calendarRow = document.createElement('div');
                    calendarRow.className = 'calendar-row';

                    for (let i = 0; i < firstDay; i++) {
                        const emptyCell = document.createElement('div');
                        emptyCell.className = 'calendar-cell empty';
                        calendarRow.appendChild(emptyCell);
                    }

                    for (let day = 1; day <= daysInMonth; day++) {
                        const calendarCell = document.createElement('div');
                        calendarCell.className = 'calendar-cell';
                        calendarCell.textContent = day;
                        if (day === now.getDate()) {
                            calendarCell.classList.add('today');
                        }
                        calendarRow.appendChild(calendarCell);

                        if ((day + firstDay) % 7 === 0) {
                            calendar.appendChild(calendarRow);
                            calendarRow = document.createElement('div');
                            calendarRow.className = 'calendar-row';
                        }
                    }
                    if (calendarRow.childNodes.length > 0) {
                        calendar.appendChild(calendarRow);
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    const now = new Date();
                    const dateTimeElem = document.getElementById('date-time');
                    const formattedDateTime = now.toLocaleDateString('en-US', {
                        year: 'numeric', month: 'long', day: 'numeric',
                        hour: 'numeric', minute: 'numeric', second: 'numeric'
                    });
                    dateTimeElem.textContent = formattedDateTime;

                    generateCalendar();
                });
            </script>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> University Dashboard</p>
    </footer>
</body>

</html>
