<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Reports</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">School System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="ramesh.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link" href="staff.php">Staff</a></li>
        <li class="nav-item"><a class="nav-link active" href="report.php">Reports</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php
$conn = mysqli_connect("localhost", "root", "", "school");

// Query to get summary of attendance
$query = "
    SELECT 
        staff_name,
        COUNT(CASE WHEN attendance_status = 'present' THEN 1 END) AS present_days,
        COUNT(CASE WHEN attendance_status = 'absent' THEN 1 END) AS absent_days,
        COUNT(*) AS total_days
    FROM atendance
    GROUP BY staff_name
    ORDER BY staff_name
";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-4">
    <h2>Staff Attendance Report</h2>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Staff Name</th>
                <th>Total Days</th>
                <th>Present</th>
                <th>Absent</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['staff_name']) ?></td>
                    <td><?= $row['total_days'] ?></td>
                    <td class="text-success"><?= $row['present_days'] ?></td>
                    <td class="text-danger"><?= $row['absent_days'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php mysqli_close($conn); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>