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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(to right, #006400, #000, #b41c1c);
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .dashboard-container {
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .table {
            background-color: #fff;
            color: #000;
        }

        h1, h2 {
            color: #fff;
        }

        .btn-info {
            background-color: #28a745;
            border: none;
        }

        .btn-info:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: #b41c1c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #8b1414;
        }

        .table thead {
            background-color: #000;
            color: #fff;
        }

        .alert {
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="text-center mb-4">
        <h1><i class="fas fa-user-shield me-2"></i>Jambo, Officer</h1>
        <h5>You are now logged in and ready to process reports.</h5>
    </div>

    <!-- Flash Messages -->
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

    <div class="mt-4 mb-3">
        <h4>📄 Pending Abstract Reports</h4>
    </div>

    <?php if ($result->num_rows === 0): ?>
        <div class="alert alert-info">No pending reports found.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
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
                            <td><?= htmlspecialchars($row['user_id']) ?></td>
                            <td><?= htmlspecialchars($row['victim_name']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($row['offence_type'])) ?></td>
                            <td><?= htmlspecialchars($row['incident_date']) ?></td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td>
                                <a href="view_report.php?id=<?= $row['user_id'] ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-end mt-4">
        <a href="../login.php" class="btn btn-danger"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
    </div>
</div>

<!-- Bootstrap Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Auto-hide alerts -->
<script>
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.classList.remove('show');
        });
    }, 4000);
</script>
</body>
</html>
