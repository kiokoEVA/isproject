<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Kenya Police Abstract System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #000000, #ff0000, #ffffff, #008000);
      background-size: 500% 500%;
      animation: shift 20s ease infinite;
      min-height: 100vh;
    }

    @keyframes shift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .contact-card {
      background-color: white;
      border-radius: 1rem;
      padding: 2rem;
      margin: 4rem auto;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      max-width: 900px;
    }

    .kenya-flag {
      width: 40px;
      margin-right: 10px;
    }

    .form-label {
      font-weight: 500;
    }

    .btn-kenya {
      background-color: #008000;
      color: white;
      font-weight: bold;
    }

    .btn-kenya:hover {
      background-color: #006400;
    }

    .info-box {
      margin-top: 2rem;
    }

    .map-placeholder {
      height: 250px;
      background-color: #e9ecef;
      border-radius: 10px;
      text-align: center;
      line-height: 250px;
      color: #6c757d;
      font-size: 1.2rem;
    }
  </style>
</head>
<body>

<div class="container contact-card">
  <div class="text-center mb-4">
    <img src="https://upload.wikimedia.org/wikipedia/commons/4/49/Flag_of_Kenya.svg" class="kenya-flag" alt="Kenyan Flag">
    <h3>Contact Us - Kenya Police Abstract System</h3>
    <p class="text-muted">We’re here to help. Reach out to us anytime.</p>
  </div>

  <form method="post" action="#">
    <div class="row g-3">
      <div class="col-md-6">
        <label for="name" class="form-label">Your Name</label>
        <input type="text" id="name" name="name" class="form-control" required>
      </div>

      <div class="col-md-6">
        <label for="email" class="form-label">Your Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
      </div>

      <div class="col-12">
        <label for="message" class="form-label">Message</label>
        <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
      </div>

      <div class="col-12 text-end">
        <button type="submit" class="btn btn-kenya px-4">Send Message</button>
      </div>
    </div>
  </form>

  <div class="row info-box mt-5">
    <div class="col-md-6">
      <h5>📍 Headquarters</h5>
      <p>Nairobi Central Police Station<br>Haile Selassie Ave, Nairobi, Kenya</p>
      <p><strong>📞 Phone:</strong> +254 700 000000</p>
      <p><strong>📧 Email:</strong> support@kenyapolice.go.ke</p>
    </div>
    
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
