<?php
session_start();

// Include your database connection file
require_once 'db.php';

// Get student register number from session (assuming it's stored there)
$student_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : null;

// Initialize variables to hold the information
$personal_info = [];
$contact_info = [];
$leave_info = [];
$course_info = [];
$internal_marks = [];

// Fetch data from the database if student_id is available
if ($student_id !== null) {
    // Fetch personal info
    $sql_personal = "SELECT 
	roll_number,
        person_type,
        student_name,
        course_name,
        semester,
        date_of_joining,
        date_of_birth,
        sex,
        blood_group,
        place_of_birth,
        department,
        supervisor,
        college_email,
        branch_name,
        bank_name,
        bank_account_no
        FROM personal_info WHERE student_id = ?";
        
    $stmt_personal = $conn->prepare($sql_personal);
    $stmt_personal->bind_param("s", $student_id);
    $stmt_personal->execute();
    $result_personal = $stmt_personal->get_result();
    $personal_info = $result_personal->fetch_assoc();

    // Fetch contact info
    $sql_contact = "SELECT 
        personal_email,
        mobile_number,
        communication_address,
        permanent_address,
        relation_type,
        primary_contact_name,
        primary_contact_occupation,
        primary_contact_email,
        primary_contact_mobile,
        primary_contact_permanent_address
        FROM contact_details WHERE student_id = ?";
        
    $stmt_contact = $conn->prepare($sql_contact);
    $stmt_contact->bind_param("s", $student_id);
    $stmt_contact->execute();
    $result_contact = $stmt_contact->get_result();
    $contact_info = $result_contact->fetch_assoc();

    // Fetch leave info
    $sql_leave = "SELECT leave_type, start_date, end_date FROM leave_info WHERE student_id = ?";
    $stmt_leave = $conn->prepare($sql_leave);
    $stmt_leave->bind_param("s", $student_id);
    $stmt_leave->execute();
    $result_leave = $stmt_leave->get_result();
    $leave_info = $result_leave->fetch_all(MYSQLI_ASSOC);

    // Fetch course info
    $sql_course = "SELECT course_name, semester FROM courses WHERE student_id = ?";
    $stmt_course = $conn->prepare($sql_course);
    $stmt_course->bind_param("s", $student_id);
    $stmt_course->execute();
    $result_course = $stmt_course->get_result();
    $course_info = $result_course->fetch_assoc();

    // Fetch internal marks
    $sql_marks = "SELECT subject_name, marks FROM internal_marks WHERE student_id = ?";
    $stmt_marks = $conn->prepare($sql_marks);
    $stmt_marks->bind_param("s", $student_id);
    $stmt_marks->execute();
    $result_marks = $stmt_marks->get_result();
    $internal_marks = $result_marks->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .menu {
            display: flex;
            justify-content: space-around;
            background: #3498db;
            padding: 10px 0;
            border-radius: 8px;
        }
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #3498db;
    color: white;
}

tr:hover {
    background: #f1f1f1;
}

td {
    vertical-align: top; /* Align content to the top */
}

        .menu a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            transition: background 0.3s;
        }
        .menu a:hover {
            background: #2980b9;
            border-radius: 5px;
        }
        .content {
            margin-top: 20px;
        }
        .section {
            display: none;
        }
        .active {
            display: block;
        }
        h2 {
            color: #3498db;
            margin-bottom: 10px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        @media (max-width: 600px) {
            .menu {
                flex-direction: column;
            }
            .menu a {
                padding: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>My Profile</h1>
<button onclick="goBack()" style="margin-bottom: 20px; padding: 10px 15px; background-color: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">
    Back
</button>

    <div class="menu">
        <a href="#" onclick="showSection('personalInfo')">Personal Info</a>
        <a href="#" onclick="showSection('contactInfo')">Contact Info</a>
        <a href="#" onclick="showSection('leaveInfo')">Leave Info</a>
        <a href="#" onclick="showSection('courseInfo')">Course Info</a>
        <a href="#" onclick="showSection('internalMarks')">Internal Marks</a>
    </div>
    
<div id="personalInfo" class="section active">
    <h2>Personal Info</h2>
    <table>
        <tr>
            <th>Label</th>
            <th>Information</th>
        </tr>
        <tr>
            <td><strong>Roll Number:</strong></td>
            <td><?= htmlspecialchars($personal_info['roll_number'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Person Type:</strong></td>
            <td><?= htmlspecialchars($personal_info['person_type'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Name:</strong></td>
            <td><?= htmlspecialchars($personal_info['student_name'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Course Name:</strong></td>
            <td><?= htmlspecialchars($personal_info['course_name'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Semester:</strong></td>
            <td><?= htmlspecialchars($personal_info['semester'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Date of Joining:</strong></td>
            <td><?= htmlspecialchars($personal_info['date_of_joining'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Date of Birth:</strong></td>
            <td><?= htmlspecialchars($personal_info['date_of_birth'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Gender:</strong></td>
            <td><?= htmlspecialchars($personal_info['sex'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Blood Group:</strong></td>
            <td><?= htmlspecialchars($personal_info['blood_group'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Place of Birth:</strong></td>
            <td><?= htmlspecialchars($personal_info['place_of_birth'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Department:</strong></td>
            <td><?= htmlspecialchars($personal_info['department'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Supervisor:</strong></td>
            <td><?= htmlspecialchars($personal_info['supervisor'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>College Email:</strong></td>
            <td><?= htmlspecialchars($personal_info['college_email'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Branch Name:</strong></td>
            <td><?= htmlspecialchars($personal_info['branch_name'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Bank Name:</strong></td>
            <td><?= htmlspecialchars($personal_info['bank_name'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td><strong>Bank Account No:</strong></td>
            <td><?= htmlspecialchars($personal_info['bank_account_no'] ?? 'N/A') ?></td>
        </tr>
    </table>
</div>


        <div id="contactInfo" class="section">
            <h2>Contact Info</h2>
            <p>Personal Email: <?= htmlspecialchars($contact_info['personal_email'] ?? 'N/A') ?></p>
            <p>Mobile Number: <?= htmlspecialchars($contact_info['mobile_number'] ?? 'N/A') ?></p>
            <p>Communication Address: <?= htmlspecialchars($contact_info['communication_address'] ?? 'N/A') ?></p>
            <p>Permanent Address: <?= htmlspecialchars($contact_info['permanent_address'] ?? 'N/A') ?></p>
            <h3>Primary Contact Details</h3>
            <p>Relation Type: <?= htmlspecialchars($contact_info['relation_type'] ?? 'N/A') ?></p>
            <p>Name: <?= htmlspecialchars($contact_info['primary_contact_name'] ?? 'N/A') ?></p>
            <p>Occupation: <?= htmlspecialchars($contact_info['primary_contact_occupation'] ?? 'N/A') ?></p>
            <p>Primary Contact Email: <?= htmlspecialchars($contact_info['primary_contact_email'] ?? 'N/A') ?></p>
            <p>Primary Contact Mobile: <?= htmlspecialchars($contact_info['primary_contact_mobile'] ?? 'N/A') ?></p>
            <p>Primary Contact Permanent Address: <?= htmlspecialchars($contact_info['primary_contact_permanent_address'] ?? 'N/A') ?></p>
        </div>

        <div id="leaveInfo" class="section">
            <h2>Leave Info</h2>
            <table>
                <tr>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
                <?php foreach ($leave_info as $leave): ?>
                    <tr>
                        <td><?= htmlspecialchars($leave['leave_type']) ?></td>
                        <td><?= htmlspecialchars($leave['start_date']) ?></td>
                        <td><?= htmlspecialchars($leave['end_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div id="courseInfo" class="section">
            <h2>Course Info</h2>
            <p>Course Name: <?= htmlspecialchars($course_info['course_name'] ?? 'N/A') ?></p>
            <p>Semester: <?= htmlspecialchars($course_info['semester'] ?? 'N/A') ?></p>
        </div>

        <div id="internalMarks" class="section">
            <h2>Internal Marks</h2>
            <table>
                <tr>
                    <th>Subject Name</th>
                    <th>Marks</th>
                </tr>
                <?php foreach ($internal_marks as $mark): ?>
                    <tr>
                        <td><?= htmlspecialchars($mark['subject_name']) ?></td>
                        <td><?= htmlspecialchars($mark['marks']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script>
function goBack() {
    window.history.back();
}

function showSection(sectionId) {
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
}
</script>
</body>
</html>
