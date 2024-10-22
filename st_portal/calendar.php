<?php
// Get the current month and year
$month = date('m');
$year = date('Y');

// Get the first day of the month
$firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

// Get the number of days in the month
$daysInMonth = date('t', $firstDayOfMonth);

// Get the day of the week for the first day of the month
$dayOfWeek = date('w', $firstDayOfMonth);

// Define reminders (later we will use jQuery to handle new reminders)
$reminders = [
    3 => 'Doctor appointment at 10 AM',
    8 => 'Project submission',
    15 => 'Birthday reminder',
    20 => 'Meeting at 2 PM',
];

// Generate calendar structure
function generateCalendar($daysInMonth, $dayOfWeek, $month, $year, $reminders) {
    $calendar = "<div id='calendar' class='table-responsive'>";
    $calendar .= "<table class='table table-bordered table-hover mx-auto'>";
    $calendar .= "<thead><tr>";

    $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    // Header row for days of the week
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='text-center bg-light'>$day</th>";
    }
    $calendar .= "</tr></thead><tbody><tr>";

    // Add empty cells for days of the previous month
    for ($i = 0; $i < $dayOfWeek; $i++) {
        $calendar .= "<td class='empty'></td>";
    }

    // Add cells for each day of the month
    $currentDay = 1;
    while ($currentDay <= $daysInMonth) {
        // Highlight current day
        $class = ($currentDay == date('j')) ? "bg-primary text-white" : "";

        // Add reminder if exists
        $reminderText = isset($reminders[$currentDay]) ? "<small class='d-block bg-warning mt-2 p-1 reminder'>" . $reminders[$currentDay] . "</small>" : '';

        // Add day cell with reminder and modal trigger
        $calendar .= "<td class='text-center align-middle $class' data-toggle='modal' data-target='#reminderModal' data-day='$currentDay'>$currentDay $reminderText</td>";

        // Move to next row after Saturday
        if (($currentDay + $dayOfWeek) % 7 == 0) {
            $calendar .= "</tr><tr>";
        }

        $currentDay++;
    }

    // Fill empty cells for next month
    while (($currentDay + $dayOfWeek - 1) % 7 != 0) {
        $calendar .= "<td class='empty'></td>";
        $currentDay++;
    }

    $calendar .= "</tr></tbody></table></div>";

    return $calendar;
}

// HTML and CSS for calendar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar with Reminders</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .table-hover tbody tr:hover td {
            background-color: #f5f5f5;
        }
        .reminder {
            font-size: 12px;
            background-color: #ffc107;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .empty {
            background-color: #f9f9f9;
        }
        .bg-primary {
            font-weight: bold;
        }
        td {
            height: 80px;
            vertical-align: middle;
        }
        .modal-title {
            font-size: 1.25rem;
        }
.table-hover tbody tr:hover td {
    background-color: #f5f5f5;
}
.reminder {
    font-size: 12px;
    background-color: #ffc107;
    padding: 2px 4px;
    border-radius: 3px;
}
.empty {
    background-color: #f9f9f9;
}
.bg-primary {
    font-weight: bold;
}
td, th {
    width: 14.28%; /* Ensures 7 equal columns (100% / 7) */
    height: 100px;  /* Fixed height for equal cell size */
    vertical-align: middle;
    text-align: center;
}

    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4"><?php echo date('F Y'); ?> Calendar</h1>

    <?php
    // Display the calendar
    echo generateCalendar($daysInMonth, $dayOfWeek, $month, $year, $reminders);
    ?>
</div>

<!-- Modal for adding reminders -->
<div class="modal fade" id="reminderModal" tabindex="-1" aria-labelledby="reminderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reminderModalLabel">Add Reminder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="reminderForm">
          <div class="form-group">
            <label for="reminderText">Reminder</label>
            <input type="text" class="form-control" id="reminderText" placeholder="Enter reminder">
          </div>
          <input type="hidden" id="reminderDay">
          <button type="submit" class="btn btn-primary">Save Reminder</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function () {
        // Trigger the modal when a day is clicked
        $('#calendar td').on('click', function () {
            var day = $(this).data('day');
            $('#reminderDay').val(day);
            $('#reminderModalLabel').text('Add Reminder for Day ' + day);
        });

        // Handle reminder form submission
        $('#reminderForm').on('submit', function (event) {
            event.preventDefault();

            var day = $('#reminderDay').val();
            var reminder = $('#reminderText').val();

            if (reminder) {
                // Add reminder to the calendar cell
                $('td[data-day="' + day + '"]').append("<small class='d-block bg-warning mt-2 p-1 reminder'>" + reminder + "</small>");

                // Close modal
                $('#reminderModal').modal('hide');

                // Reset the form
                $('#reminderForm')[0].reset();
            }
        });
    });
</script>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
