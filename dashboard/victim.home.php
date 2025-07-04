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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css ">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .header {
            padding: 2rem;
            text-align: center;
        }

        .option-card {
            margin-top: 2rem;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .option-card:hover {
            transform: translateY(-5px);
        }

        .green-card {
            background-color: #007b33; /* Green */
            color: white;
        }

        .red-card {
            background-color: #d9534f; /* Red */
            color: white;
        }

        .icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .btn-custom {
            background-color: transparent;
            border: none;
            color: inherit;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .btn-custom:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .header {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0 m-0">
    <div class="row g-0">

        <!-- Header -->
        <div class="col-12">
            <div class="header">
                <h1>Welcome, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Victim') ?></h1>
            </div>
        </div>

        <!-- Buttons -->
        <div class="col-12">
            <div class="row g-3 justify-content-center">

                <!-- Request Abstract Button -->
                <div class="col-md-6">
                    <div class="option-card green-card">
                        <i class="fas fa-file-medical icon"></i>
                        <h4>Request Abstract</h4>
                        <p class="text-muted">Fill out a report to request your police abstract.</p>
                        <a href="victim_upload.php" class="btn-custom">Submit Report</a>
                    </div>
                </div>

                <!-- Track Status Button -->
                <div class="col-md-6">
                    <div class="option-card red-card">
                        <i class="fas fa-search-location icon"></i>
                        <h4>Track Abstract Status</h4>
                        <p class="text-muted">Check the status of your submitted reports.</p>
                        <a href="../submissions/track_status.php" class="btn-custom">View Status</a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Logout Button -->
        <div class="col-12 text-center mt-4 mb-5">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>