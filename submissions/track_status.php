<?php 
session_start();

// Check if user is logged in and is a victim
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'victim') {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';


$user_id = $_SESSION['user']['id'];

// Fetch all reports by this user
$sql = "SELECT * FROM abstract_reports WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Abstract Status - Kenya Police System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
        background-color: rgba(0, 123, 255, 0.3); /* Bootstrap blue, 30% opacity */

        }
        .status-pill {
            font-weight: bold;
            padding: 0.25em 0.6em;
            border-radius: 12px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">📄 Track Your Abstract Report Status</h2>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- No Reports Message -->
    <?php if ($result->num_rows === 0): ?>
        <div class="alert alert-info text-center">You haven't submitted any abstract reports yet.</div>
        <div class="text-center mt-3">
            <a href="dashboard/victim_dashboard.php" class="btn btn-primary">Submit New Abstract</a>
        </div>
    <?php else: ?>
        <!-- Reports Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Report ID</th>
                        <th>Offence Type</th>
                        <th>Incident Date</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="text-center">
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($row['offence_type'])) ?></td>
                            <td><?= htmlspecialchars($row['incident_date']) ?></td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td>
                                <?php
                                $status = strtolower($row['approval_status']);
                                $badge_class = match($status) {
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    default => 'bg-warning text-dark'
                                };
                                ?>
                                <span class="status-pill <?= $badge_class ?>">
                                    <?= ucfirst($status) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- Back/Home Buttons -->
    <!-- Back/Home Buttons -->
<!-- Back/Home Buttons -->
<div class="d-flex justify-content-between mt-4">
    <!-- Go up one level to access dashboard folder -->
    <a href="../dashboard/victim.home.php" class="btn btn-outline-secondary">Back to Dashboard</a>
    <a href="../dashboard/victim_upload.php" class="btn btn-primary">Submit New Report</a>
</div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
