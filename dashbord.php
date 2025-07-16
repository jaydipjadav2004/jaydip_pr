<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Welcome, <?= htmlspecialchars($_SESSION["username"]) ?></span>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>
<div class="container mt-4">
    <h3>Dashboard</h3>
    <p>This is a protected page. Only logged-in users can see this.</p>
</div>
</body>
</html>