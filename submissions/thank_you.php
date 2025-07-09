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
    <title>Thank You - Kenya Police Abstract System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #000, #ff0000, #ffffff, #008000);
            background-size: 400% 400%;
            animation: flagShift 10s ease infinite;
            color: #000;
        }

        @keyframes flagShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .thank-card {
            background: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            margin: 80px auto;
            text-align: center;
        }

        .btn-track {
            background-color: #008000;
            color: #fff;
            font-weight: bold;
            border: none;
        }

        .btn-track:hover {
            background-color: #006400;
        }

        .flag {
            width: 50px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="thank-card">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Flag_of_Kenya.svg/1200px-Flag_of_Kenya.svg.png" class="flag" alt="Kenya Flag">
    <h2 class="mb-3">Asante Sana!</h2>
    <p>Your report has been successfully submitted to the Kenya Police Issuance Abstract System.</p>
    <p><strong>Reference ID:</strong> <?= htmlspecialchars($request_id) ?></p>
    <a href="track_status.php" class="btn btn-track mt-3">Track My Request</a>
</div>

</body>
</html>
