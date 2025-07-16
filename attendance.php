<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Records</title>
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
        <li class="nav-item"><a class="nav-link active" href="nasa.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="attendance.php">Attendance</a></li>
        <li class="nav-item"><a class="nav-link" href="staff.php">Staff</a></li>
        <li class="nav-item"><a class="nav-link" href="report.php">Reports</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php
$conn = mysqli_connect("localhost", "root", "", "school");

// Optional: filter by staff name
$filter = "";
if (!empty($_GET['staff'])) {
    $staff = mysqli_real_escape_string($conn, $_GET['staff']);
    $filter = "WHERE staff_name = '$staff'";
}

$result = mysqli_query($conn, "SELECT * FROM atendance $filter ORDER BY attendance_date DESC");
$staffList = mysqli_query($conn, "SELECT DISTINCT staff_name FROM atendance");
?>

<div class="container mt-4">
    <h2>Attendance Records</h2>

    <!-- Filter Form -->
    <form method="GET" class="row mb-4">
        <div class="col-md-4">
            <select name="staff" class="form-select">
                <option value="">All Staff</option>
                <?php while ($staffRow = mysqli_fetch_assoc($staffList)) : ?>
                    <option value="<?= htmlspecialchars($staffRow['staff_name']) ?>" 
                        <?= (isset($_GET['staff']) && $_GET['staff'] == $staffRow['staff_name']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($staffRow['staff_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
        <div class="col-md-2">
            <a href="attendance.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Attendance Table -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Staff Name</th>
                <th>Post</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['staff_name']) ?></td>
                <td><?= htmlspecialchars($row['post_name']) ?></td>
                <td><?= htmlspecialchars($row['attendance_date']) ?></td>
                <td class="<?= $row['attendance_status'] === 'present' ? 'text-success' : 'text-danger' ?>">
                    <?= htmlspecialchars(ucfirst($row['attendance_status'])) ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php mysqli_close($conn); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>