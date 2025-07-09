<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenya Police Abstract Portal</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (optional for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            padding-top: 70px; /* Offset for fixed navbar */
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            backdrop-filter: blur(8px);
            background-color:  #006400;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 600;
            color: #ffffff !important;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }

        .navbar-brand:hover {
            color: #e8f0fe !important;
        }

        .nav-link {
            color: #ffffff !important;
            margin-left: 1rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #dbeafe !important;
            text-decoration: underline;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }
    </style>
</head>
<body>

<!-- Modern Navigation Bar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-shield-alt me-2"></i> Kenya Police Abstract
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="mainNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="home.php"><i class="fas fa-home me-1"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php"><i class="fas fa-info-circle me-1"></i> About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact us.php"><i class="fas fa-envelope me-1"></i> Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
