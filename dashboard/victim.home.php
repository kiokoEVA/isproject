<?php 
session_start();

// Ensure user is logged in and is a victim
if (!isset($_SESSION['user']) || strtolower($_SESSION['user']['role']) !== 'victim') {
    $_SESSION['error'] = "You must be logged in as a victim to access this page.";
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Victim Dashboard - Kenya Police Abstract System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #006400, #000, #b41c1c);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .dashboard-container {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            width: 100%;
            max-width: 900px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .header h1 {
            font-weight: bold;
            font-size: 2rem;
            color: #fff;
        }

        .option-card {
            padding: 2rem 1rem;
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
            color: #fff;
            height: 100%;
        }

        .option-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }

        .green-card {
            background-color: #006400;
        }

        .red-card {
            background-color: #b41c1c;
        }

        .icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .btn-custom {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-weight: bold;
            color: #fff;
            border: 2px solid #fff;
            border-radius: 30px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .logout-btn {
            margin-top: 30px;
        }

        .logout-btn a {
            background-color: #000;
            border: none;
            padding: 10px 24px;
            color: #fff;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .logout-btn a:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

<div class="dashboard-container text-center">
    <div class="header mb-4">
        <h1><i class="fas fa-user-shield me-2"></i>Welcome, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Victim') ?></h1>
        <p class="text-white-50">Manage and track your police abstract reports with ease.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Submit Report -->
        <div class="col-md-6">
            <div class="option-card green-card h-100">
                <i class="fas fa-file-medical icon"></i>
                <h4 class="fw-bold">Request Abstract</h4>
                <p>Fill out a report to request your police abstract.</p>
                <a href="victim_upload.php" class="btn-custom mt-3">Submit Report</a>
            </div>
        </div>

        <!-- Track Status -->
        <div class="col-md-6">
            <div class="option-card red-card h-100">
                <i class="fas fa-search-location icon"></i>
                <h4 class="fw-bold">Track Abstract Status</h4>
                <p>Check the status of your submitted reports anytime.</p>
                <a href="../submissions/track_status.php" class="btn-custom mt-3">View Status</a>
            </div>
        </div>
    </div>

    <div class="logout-btn text-center mt-5">
        <a href="../login.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
