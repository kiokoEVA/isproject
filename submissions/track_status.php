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
            background: linear-gradient(to right, #006400, #000000, #b41c1c); /* Kenyan flag colors */
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 2rem;
            margin-top: 40px;
            color: #000;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        .status-pill {
            font-weight: bold;
            padding: 0.35em 0.9em;
            border-radius: 15px;
            font-size: 0.85rem;
            display: inline-block;
        }

        .btn-primary {
            background-color: #006400;
            border: none;
        }

        .btn-primary:hover {
            background-color: #045a04;
        }

        .btn-outline-secondary {
            border-color: #000;
            color: #000;
        }

        .btn-outline-secondary:hover {
            background-color: #000;
            color: #fff;
        }

        .table thead {
            background-color: #000;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">📄 Track Your Abstract Report Status</h2>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if ($result->num_rows === 0): ?>
        <div class="alert alert-info text-center">You haven't submitted any abstract reports yet.</div>
        <div class="text-center mt-3">
            <a href="../dashboard/victim_upload.php" class="btn btn-primary">Submit New Abstract</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Offence Type</th>
                        <th>Incident Date</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): 
                        $status = strtolower($row['approval_status']);
                        $badge_class = match($status) {
                            'approved' => 'bg-success',
                            'rejected' => 'bg-danger',
                            default => 'bg-warning text-dark'
                        };
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($row['offence_type'])) ?></td>
                            <td><?= htmlspecialchars($row['incident_date']) ?></td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td>
                                <span class="status-pill <?= $badge_class ?>">
                                    <?= ucfirst($status) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <?php if ($status === 'approved'): ?>
                                    <a href="download_abstract.php?report_id=<?= $row['id'] ?>" 
                                       class="btn btn-success btn-sm" 
                                       download>
                                       📥 Download
                                    </a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- Navigation Buttons -->
    <div class="d-flex justify-content-between mt-4">
        <a href="../dashboard/victim.home.php" class="btn btn-outline-secondary">← Back to Dashboard</a>
        <a href="../dashboard/victim_upload.php" class="btn btn-primary">Submit New Report</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
