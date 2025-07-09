<?php 
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'police') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Missing report ID.";
    header("Location:officer.php");
    exit;
}

$id = (int)$_GET['id'];

// Fetch report with victim details
$sql = "SELECT r.*, u.name AS victim_name, u.email, u.phone, u.address
        FROM abstract_reports r
        JOIN users u ON r.user_id = u.id
        WHERE r.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Report not found.";
    header("Location:officer.php");
    exit;
}

$report = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #000000, #ff0000, #ffffff, #008000);
            background-size: 400% 400%;
            animation: bgMove 12s ease infinite;
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes bgMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            margin-top: 60px;
            background-color: #ffffffee;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .card {
            margin-bottom: 2rem;
        }

        .card-header {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .btn {
            min-width: 120px;
        }

        h2 {
            color: #000000;
            font-weight: bold;
            margin-bottom: 2rem;
            text-align: center;
        }

        .actions {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Report Details (ID: <?= $report['user_id'] ?>)</h2>

    <div class="card">
        <div class="card-header bg-dark text-white">Victim Information</div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6"><strong>Name:</strong> <?= htmlspecialchars($report['victim_name']) ?></div>
                <div class="col-md-6"><strong>Email:</strong> <?= htmlspecialchars($report['email']) ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Phone:</strong> <?= htmlspecialchars($report['phone']) ?></div>
                <div class="col-md-6"><strong>Address:</strong> <?= htmlspecialchars($report['address']) ?></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-success text-white">Report Information</div>
        <div class="card-body">
            <p><strong>Offence Type:</strong> <?= ucfirst(htmlspecialchars($report['offence_type'])) ?></p>
            <p><strong>Incident Date:</strong> <?= htmlspecialchars($report['incident_date']) ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($report['location']) ?></p>
            <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($report['description'])) ?></p>
        </div>
    </div>

    <div class="actions d-flex justify-content-between flex-wrap">
        <a href="officer.php" class="btn btn-outline-secondary mb-2">← Back</a>
        <div class="d-flex gap-2">
            <a href="approve_reject.php?id=<?= $report['id'] ?>&action=approve" class="btn btn-success"
               onclick="return confirm('Are you sure you want to approve this report?')">Approve</a>
            <a href="approve_reject.php?id=<?= $report['id'] ?>&action=reject" class="btn btn-danger"
               onclick="return confirm('Are you sure you want to reject this report?')">Reject</a>
        </div>
    </div>
</div>

</body>
</html>
