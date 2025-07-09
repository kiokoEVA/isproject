<?php
session_start();

// Check login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'lawyer') {
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
            WHERE r.user_id = ? AND r.approval_status = 'approved' LIMIT 1";

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
    <title>Welcome Wakili - Kenya Abstract System</title>

    <!-- Bootstrap + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(to right, #000000, #ff0000, #ffffff, #008000);
            background-size: 400% 400%;
            animation: flagWave 15s ease infinite;
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes flagWave {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card-check {
            max-width: 500px;
            padding: 2.5rem;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            margin-top: 40px;
        }

        .input-group-text {
            background-color: #000;
            color: white;
            border: none;
        }

        .btn-kenya {
            background-color: #008000;
            color: white;
            font-weight: bold;
        }

        .btn-kenya:hover {
            background-color: #006400;
        }

        .footer-btn {
            position: fixed;
            bottom: 15px;
            right: 15px;
        }

        h1 {
            font-weight: bold;
            color: #000;
        }

        .modal-success .modal-header {
            background-color: #008000;
        }

        .modal-danger .modal-header {
            background-color: #dc3545;
        }

        .flag-icon {
            width: 40px;
            margin-right: 10px;
        }

        .center-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
        }
    </style>
</head>
<body>

<div class="container text-center mt-4">
    
    <h1><i class="fas fa-scale-balanced"></i> Welcome, Wakili</h1>
    <p class="lead text-white">Check if the abstract is approved for legal use.</p>
</div>

<div class="center-wrapper">
    <div class="container">
        <div class="card card-check mx-auto">
            <h5 class="text-center mb-4">🔍 Verify Abstract by User ID</h5>
            <form method="POST">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                    
                    <input type="number" name="user_id" class="form-control text-center" placeholder="e.g. 1001" required>
                    <button type="submit" class="btn btn-kenya btn-lg">
                        <i class="fas fa-search"></i> Check
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<?php if ($report): ?>
    <div class="modal fade show" id="statusModal" tabindex="-1" style="display: block;" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-success bg-white">
                <div class="modal-header text-white">
                    <h5 class="modal-title">✅ Abstract Verified</h5>
                </div>
                <div class="modal-body">
                    <p><strong>User ID:</strong> <?= htmlspecialchars($report['report_id']) ?></p>
                    <p><strong>Name:</strong> <?= htmlspecialchars($report['name']) ?></p>
                    <p>This abstract has been <strong class="text-success">approved by police</strong> and is valid for court proceedings.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="lawyer.php" class="btn btn-secondary">Close</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Error Modal -->
<?php if ($error): ?>
    <div class="modal fade show" id="statusModal" tabindex="-1" style="display: block;" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-danger bg-white">
                <div class="modal-header text-white">
                    <h5 class="modal-title">❌ Abstract Not Approved</h5>
                </div>
                <div class="modal-body text-danger text-center">
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="lawyer.php" class="btn btn-secondary">Try Again</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Logout -->
<a href="../login.php" class="btn btn-danger footer-btn">Logout</a>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
