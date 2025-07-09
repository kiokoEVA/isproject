<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home - Kenya Police Abstract System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fff;
      padding-top: 70px;
    }

    .hero {
      background: linear-gradient(to right, #000, #b41c1c); /* black to red */
      color: white;
      padding: 80px 0;
      text-align: center;
    }

    .hero h1 {
      font-weight: bold;
      font-size: 2.8rem;
    }

    .hero p {
      font-size: 1.2rem;
      margin-top: 1rem;
    }

    .btn-cta {
      margin-top: 2rem;
      padding: 12px 30px;
      font-size: 1.1rem;
      background-color: #006400; /* dark green */
      border: none;
    }

    .btn-cta:hover {
      background-color: #004d00;
    }

    .features {
      padding: 60px 0;
    }

    .feature-icon {
      font-size: 2.5rem;
      color: #b41c1c; /* red */
      margin-bottom: 15px;
    }

    .section-title {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 40px;
      text-align: center;
      color: #000;
    }

    .vision {
      background: #e6f4e6; /* greenish white */
      padding: 60px 0;
    }

    .footer {
      background-color: #000;
      color: white;
      padding: 30px 0;
      text-align: center;
    }

    .footer a {
      color: #ffffffcc;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h1><i class="fas fa-shield-alt me-2"></i> Kenya Police Abstract Issuance System</h1>
    <p>Fast, secure and transparent way to access police abstracts in Kenya</p>
    <a href="register.php" class="btn btn-cta text-white"><i class="fas fa-sign-in-alt me-1"></i> Get Started</a>
  </div>
</section>

<!-- Features Section -->
<section class="features">
  <div class="container">
    <h2 class="section-title">How It Works</h2>
    <div class="row text-center">
      <div class="col-md-3 mb-4">
        <div class="feature-icon"><i class="fas fa-user-shield"></i></div>
        <h5>For Victims</h5>
        <p>Submit a police abstract request and track its approval status online.</p>
      </div>
      <div class="col-md-3 mb-4">
        <div class="feature-icon"><i class="fas fa-user-tie"></i></div>
        <h5>For Police</h5>
        <p>Review, approve, and manage reports with secure access.</p>
      </div>
      <div class="col-md-3 mb-4">
        <div class="feature-icon"><i class="fas fa-scale-balanced"></i></div>
        <h5>For Lawyers</h5>
        <p>Check if abstracts are valid and admissible in legal cases.</p>
      </div>
      <div class="col-md-3 mb-4">
        <div class="feature-icon"><i class="fas fa-building-shield"></i></div>
        <h5>For Insurance</h5>
        <p>Validate claims by verifying abstract authenticity.</p>
      </div>
    </div>
  </div>
</section>

<!-- Vision Section -->
<section class="vision">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4">
        <h2 class="fw-bold" style="color:#006400">Why This System Matters</h2>
        <p class="lead text-dark">
          The Kenya Police Abstract System reduces paperwork, speeds up response times, and builds trust between citizens and institutions.
        </p>
        <p class="text-dark">
          By digitizing reporting and approvals, we foster transparency, security, and accountability for all.
        </p>
      </div>
      <div class="col-md-6 text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/3021/3021213.png" alt="System illustration" style="max-width: 80%;">
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <p class="mb-2">&copy; <?= date('Y') ?> Kenya Police Abstract System. All rights reserved.</p>
    <p class="mb-0">
      <a href="about.php">About Us</a> |
      <a href="login.php">Login</a> |
      <a href="contact us.php">Contact Us</a>
    </p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
