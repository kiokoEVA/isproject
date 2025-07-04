<?php 
session_start();

// Check login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'police') {
    header("Location: ../login.php");
    exit;
}

include '../includes/db.php';

// Fetch all pending reports
$sql = "SELECT r.*, u.name AS victim_name, u.email AS victim_email 
        FROM abstract_reports r
        JOIN users u ON r.user_id = u.id
        WHERE r.approval_status = 'pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Police Dashboard - Kenya Police Abstract System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"  rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 text-center">
    <h1>Jambo, Officer</h1>
    <h2>You are now logged in.</h2>

    <!-- ✅ Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <p class="mb-4">Pending Reports</p>

    <?php if ($result->num_rows === 0): ?>
        <div class="alert alert-info">No pending reports found.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Victim</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['victim_name']) ?></td>
                        <td><?= ucfirst(htmlspecialchars($row['offence_type'])) ?></td>
                        <td><?= htmlspecialchars($row['incident_date']) ?></td>
                        <td><?= htmlspecialchars($row['location']) ?></td>
                        <td>
                            <a href="approve_reject.php?id=<?= $row['id'] ?>&action=approve" class="btn btn-success btn-sm"
                               onclick="return confirm('Are you sure you want to approve this report?')">Approve</a>
                            <a href="approve_reject.php?id=<?= $row['id'] ?>&action=reject" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to reject this report?')">Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="../login.php" class="btn btn-danger">← Logout</a>
        </div>
    </div>
</div>

<!-- ✅ Bootstrap & Auto Fade Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
<script>
// Auto-hide alerts after 4 seconds
setTimeout(function () {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        let fade = new bootstrap.Alert(alert);
        alert.classList.remove('show');
    });
}, 4000);
</script>

</body>
</html>
