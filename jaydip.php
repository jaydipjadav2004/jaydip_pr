<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Staff Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f2f2f2;
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "school");

// Add new staff
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_staff_name']) && isset($_POST['new_staff_position'])) {
    $name = $_POST['new_staff_name'];
    $position = $_POST['new_staff_position'];
    mysqli_query( $conn, "INSERT INTO `staff`(`name`, `position`)VALUES ('$name', '$position')");
}

// Mark attendance
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['staff_name']) && isset($_POST['post_name']) && isset($_POST['attendance_date']) && isset($_POST['attendance_status'])) {
    $staff_name = $_POST['staff_name'];
    $post_name = $_POST['post_name'];
    $date = $_POST['attendance_date'];
    $status = $_POST['attendance_status'];
    mysqli_query ($conn, SELECT `id`, `staffname`, `postname`, `attendance_date` FROM `mogal` WHERE 1) VALUES ('$staff_name', '$post_name', '$date', '$status')");
}

// Fetch staff list
$staffResult = mysqli_query($conn, "SELECT * FROM staff");
$staffData = mysqli_fetch_all($staffResult, MYSQLI_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>School Staff Attendance</h1>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="row">
        <div class="col-md-6">
            <h2>Staff Information</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($staffData as $staff): ?>
                    <tr>
                        <td><?= htmlspecialchars($staff['name']) ?></td>
                        <td><?= htmlspecialchars($staff['position']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Add New Staff Form -->
            <h3>Add New Staff</h3>
            <form method="POST">
                <input type="text" name="new_staff_name" placeholder="New Staff Name" required class="form-control mb-2">
                <input type="text" name="new_staff_position" placeholder="Position" required class="form-control mb-2">
                <button type="submit" class="btn btn-success">Add Staff</button>
            </form>
        </div>

        <!-- Attendance Form -->
        <div class="col-md-6">
            <h2>Mark Attendance</h2>
            <form method="POST">
                <div class="form-group mb-2">
                    <label>Select Staff:</label>
                    <select name="staff_name" class="form-control" required>
                        <option value="">Select Staff</option>
                        <?php foreach ($staffData as $staff): ?>
                            <option value="<?= htmlspecialchars($staff['name']) ?>"><?= htmlspecialchars($staff['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label>Post Name:</label>
                    <input type="text" name="post_name" class="form-control" required>
                </div>

                <div class="form-group mb-2">
                    <label>Attendance Date:</label>
                    <input type="date" name="attendance_date" class="form-control" required>
                </div>

                <div class="form-group mb-2">
                    <label>Attendance Status:</label>
                    <select name="attendance_status" class="form-control" required>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Mark Attendance</button>
            </form>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Attendance Records</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Post</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $attendanceResult = mysqli_query($conn, "SELECT * FROM `atendance` ORDER BY attendance_date DESC");
                while ($row = mysqli_fetch_assoc($attendanceResult)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['staff_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['post_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['attendance_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['attendance_status']) . "</td>";
                    echo "</tr>";
                }
                mysqli_close($conn);
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>