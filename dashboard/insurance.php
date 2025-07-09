<?php 
session_start();

// Check login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'insurance') {
    header("Location: ../login.php");
    exit;
}

include '../includes/db.php';
$error = '';
$report = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    $sql = "SELECT r.user_id AS report_id, r.approval_status, u.name 
            FROM abstract_reports r
            JOIN users u ON r.user_id = u.id
            WHERE r.user_id = ? AND r.approval_status = 'approved'
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $error = "No approved abstract found for this user.";
    } else {
        $report = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insurance Dashboard - Kenya Abstract System</title>

    <!-- Bootstrap + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(to right, #000000, #ff0000, #ffffff, #008000);
            background-size: 400% 400%;
            animation: flagWave 20s ease infinite;
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes flagWave {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card-check {
            max-width: 520px;
            margin: 60px auto;
            padding: 2rem;
            border-radius: 1rem;
            background-color: #fff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .title-flag {
            color: #000;
            font-weight: bold;
        }

        .btn-kenya {
            background-color: #008000;
            color: #fff;
            font-weight: 600;
        }

        .btn-kenya:hover {
            background-color: #005e00;
        }

        .input-group-text {
            background-color: #000;
            color: #fff;
        }

        .footer-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        .modal-success .modal-header {
            background-color: #008000;
            color: white;
        }

        .modal-danger .modal-header {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<div class="container text-center mt-4">
    
    <h1 class="mt-3 title-flag"><i class="fas fa-shield-alt"></i> Insurance Dashboard</h1>
    <p class="lead text-white">Verify approved abstracts for insurance processing.</p>
</div>

<div class="card card-check">
    <h5 class="text-center mb-4">🔍 Enter Victim's User ID to Verify</h5>
    <form method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
            <input type="number" name="user_id" class="form-control text-center" placeholder="e.g. 1001" required>
            <button type="submit" class="btn btn-kenya">
                <i class="fas fa-search"></i> Check
            </button>
        </div>
    </form>
</div>

<!-- Success Modal -->
<?php if ($report): ?>
<div class="modal fade show" id="statusModal" tabindex="-1" style="display: block;" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-success text-center">
            <div class="modal-header">
                <h5 class="modal-title">✅ Abstract Verified</h5>
            </div>
            <div class="modal-body">
                <p><strong>User ID:</strong> <?= htmlspecialchars($report['report_id']) ?></p>
                <p><strong>Name:</strong> <?= htmlspecialchars($report['name']) ?></p>
                <p>This abstract is <span class="text-success fw-bold">valid for insurance claims</span>.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="insurance.php" class="btn btn-secondary">Close</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Error Modal -->
<?php if ($error): ?>
<div class="modal fade show" id="statusModal" tabindex="-1" style="display: block;" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-danger text-center">
            <div class="modal-header">
                <h5 class="modal-title">❌ Abstract Not Found</h5>
            </div>
            <div class="modal-body text-danger">
                <p><?= htmlspecialchars($error) ?></p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="insurance.php" class="btn btn-secondary">Try Again</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Logout Button -->
<a href="../logout.php" class="btn btn-danger footer-btn">Logout</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Auto-show Modal -->
<script>
    window.onload = () => {
        const modal = document.getElementById('statusModal');
        if (modal) {
            const myModal = new bootstrap.Modal(modal);
            myModal.show();
        }
    };
</script>

</body>
</html>
