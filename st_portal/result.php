<?php
session_start();

// Include your database connection file
require_once 'db.php';

// Get student register number from session (assuming it's stored there)
$student_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : null;

// Handle AJAX request to fetch results
if (isset($_POST['fetch_results'])) {
    if ($student_id !== null) {
        // Prepare SQL query to fetch results
        $sql_results = "SELECT semester, subject_code, subject_name, grade, credits, result FROM results WHERE student_id = ?";
        $stmt_results = $conn->prepare($sql_results);
        
        if ($stmt_results) {
            $stmt_results->bind_param("s", $student_id);
            $stmt_results->execute();
            $result = $stmt_results->get_result();

            if ($result->num_rows > 0) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }

                echo json_encode(['rows' => $rows]);
            } else {
                echo json_encode(['error' => 'No results found for this student.']);
            }
            $stmt_results->close();
        } else {
            echo json_encode(['error' => "Prepare statement error for results: " . $conn->error]);
        }
    } else {
        echo json_encode(['error' => 'Student ID not found in session.']);
    }
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results</title>
    <style>
        /* Reset default margins and paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General body styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f4f7f9, #e6e9f0);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Centering the main container */
        .main {
            padding: 30px;
            width: 60%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .main h2 {
            margin-bottom: 20px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
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
            background-color: #ddd;
        }

        p.error {
            color: #d9534f;
            font-weight: bold;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .main {
                width: 90%;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="main">
    <h2>Student Examination Results</h2>
    <div id="results">
        <p>Loading results...</p> <!-- Placeholder while results load -->
    </div>
</div>

<script>
    // Function to fetch results using AJAX
    function loadResults() {
        $.ajax({
            url: 'http://localhost/st_portal/result.php', // Same file handles both page and AJAX requests
            type: 'POST',
            data: { fetch_results: true },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.error) {
                    $('#results').html('<p class="error">' + data.error + '</p>');
                } else {
                    // Create results table
                    let table = '<table><tr><th>Semester</th><th>Subject Code</th><th>Subject Name</th><th>Grade</th><th>Credits</th><th>Result</th></tr>';
                    data.rows.forEach(function (row) {
                        table += '<tr><td>' + row.semester + '</td><td>' + row.subject_code + '</td><td>' + row.subject_name + '</td><td>' + row.grade + '</td><td>' + row.credits + '</td><td>' + row.result + '</td></tr>';
                    });
                    table += '</table>';
                    $('#results').html(table);
                }
            },
            error: function (xhr, status, error) {
                $('#results').html('<p class="error">Error loading results: ' + error + '</p>');
            }
        });
    }

    // Load results when the page is ready
    $(document).ready(function () {
        loadResults();
    });
</script>

</body>
</html> 