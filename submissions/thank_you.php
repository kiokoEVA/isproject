<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'victim') {
    header("Location: ../login.php");
    exit;
}

$request_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"  rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 text-center">
    <h2 class="mb-4">Thank You!</h2>
    <p>Your report has been successfully submitted.</p>
    <p><strong>Reference ID:</strong> <?= htmlspecialchars($request_id) ?></p>
    <a href="track_status.php" class="btn btn-primary">Track My Request</a>
</div>

</body>
</html>