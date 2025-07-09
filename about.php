<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - Kenya Police Abstract System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fff;
      padding-top: 70px;
    }

    .about-hero {
      background: linear-gradient(to right, #000, #b41c1c);
      color: white;
      padding: 80px 0;
      text-align: center;
    }

    .about-hero h1 {
      font-weight: bold;
      font-size: 2.8rem;
    }

    .about-hero p {
      font-size: 1.2rem;
      margin-top: 1rem;
    }

    .section {
      padding: 60px 0;
    }

    .section-title {
      font-size: 2rem;
      font-weight: bold;
      color: #000;
      margin-bottom: 40px;
      text-align: center;
    }

    .icon-box {
      font-size: 2.5rem;
      color: #b41c1c;
      margin-bottom: 15px;
    }

    .team-img {
      border-radius: 50%;
      width: 120px;
      height: 120px;
      object-fit: cover;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
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
<section class="about-hero">
  <div class="container">
    <h1><i class="fas fa-info-circle me-2"></i> About Us</h1>
    <p>Transforming police services through digital innovation and transparency.</p>
  </div>
</section>

<!-- Mission Section -->
<section class="section bg-white">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4">
        <h2 class="fw-bold text-success">Our Mission</h2>
        <p class="lead text-dark">
          The Kenya Police Abstract System digitizes the process of reporting, verifying, and tracking police abstracts.
        </p>
        <p class="text-dark">
          We aim to ensure transparency, accessibility, and fast communication across agencies and citizens to deliver better justice outcomes.
        </p>
      </div>
      <div class="col-md-6 text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/2840/2840561.png" alt="Mission" style="max-width: 80%;">
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="section bg-light">
  <div class="container">
    <h2 class="section-title">Why Choose Us</h2>
    <div class="row text-center">
      <div class="col-md-4">
        <div class="icon-box"><i class="fas fa-lock"></i></div>
        <h5>Data Security</h5>
        <p>We use encrypted connections and secure databases to keep your information safe and confidential.</p>
      </div>
      <div class="col-md-4">
        <div class="icon-box"><i class="fas fa-stopwatch"></i></div>
        <h5>Real-Time Access</h5>
        <p>Track the status of your abstract anytime from anywhere with your unique request ID.</p>
      </div>
      <div class="col-md-4">
        <div class="icon-box"><i class="fas fa-balance-scale"></i></div>
        <h5>Justice-Focused</h5>
        <p>We support law enforcement, courts, and insurance agencies with verified digital abstracts.</p>
      </div>
    </div>
  </div>
</section>

<!-- Our Team -->
<section class="section bg-white">
  <div class="container text-center">
    <h2 class="section-title">Meet the Visionaries</h2>
    <p class="lead mb-5 text-muted">Experts from law enforcement, technology, and civic innovation working together.</p>
    <div class="row justify-content-center">
      <div class="col-md-3 mb-4">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="team-img mb-3" alt="Everlyne">
        <h6 class="fw-bold mb-1">Everlyne Kioko</h6>
        <p class="text-muted small">Lead Developer</p>
      </div>
      <div class="col-md-3 mb-4">
        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="team-img mb-3" alt="Jane">
        <h6 class="fw-bold mb-1">Jane Muthoni</h6>
        <p class="text-muted small">Legal Advisor</p>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <p class="mb-2">&copy; <?= date('Y') ?> Kenya Police Abstract System. All rights reserved.</p>
    <p class="mb-0">
      <a href="index.php">Home</a> |
      <a href="contact.php">Contact</a> |
      <a href="login.php">Login</a>
    </p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

