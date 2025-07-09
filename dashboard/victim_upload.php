<?php  
session_start();

// Check login
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['police', 'victim'])) {
    header("Location: login.php");
    exit;
}

$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Offence - Kenya Police Abstract System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #006400, #000, #b41c1c);
            font-family: 'Segoe UI', sans-serif;
            padding: 30px 15px;
            color: #fff;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            border-radius: 16px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        }

        h3 {
            text-align: center;
            margin-bottom: 2rem;
            font-weight: bold;
            color: #fff;
        }

        .form-label {
            color: #fff;
            font-weight: 500;
        }

        .form-control,
        .form-select {
            background-color: #f8f9fa;
        }

        .btn-submit {
            background-color: #28a745;
            border: none;
            font-weight: bold;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        small.text-muted {
            color: #ddd !important;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h3>📝 Report an Offence</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars(urldecode($success)) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars(urldecode($error)) ?></div>
    <?php endif; ?>

    <form action="../submissions/submit.php" method="POST" enctype="multipart/form-data">

        <!-- Offence Type -->
        <div class="mb-3">
            <label for="offence_type" class="form-label">Type of Offence</label>
            <select id="offence_type" name="offence_type" class="form-select" required>
                <option value="">-- Select Offence Type --</option>
                <option value="criminal">Criminal Offence</option>
                <option value="traffic">Traffic Offence</option>
            </select>
        </div>

        <!-- Date & Time -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="incident_date" class="form-label">Date of Incident</label>
                <input type="date" name="incident_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="incident_time" class="form-label">Time of Incident</label>
                <input type="time" name="incident_time" class="form-control" required>
            </div>
        </div>

        <!-- Location -->
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" class="form-control" placeholder="e.g., CBD, Kisumu" required>
        </div>

        <!-- Victim Information -->
        <div class="mb-3">
            <label class="form-label">Victim Name</label>
            <input type="text" name="victim_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Victim Phone</label>
            <input type="tel" name="victim_phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Victim Address</label>
            <textarea name="victim_address" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Victim ID Number</label>
            <input type="text" name="victim_national_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Victim Date of Birth</label>
            <input type="date" name="victim_dob" class="form-control" required>
        </div>

        <!-- Offender -->
        <div class="mb-3">
            <label class="form-label">Offender Details</label>
            <textarea name="offender_details" class="form-control" required></textarea>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <!-- File Upload: Evidence -->
        <div class="mb-3">
            <label class="form-label">Supporting Documents</label>
            <input type="file" name="attachments[]" multiple class="form-control">
                   <!-- NEW: Abstract Upload -->
 <small class="text-muted">Optional evidence (images, scans, etc.)</small>
        </div>

        

        <!-- Submit -->
        <button type="submit" class="btn btn-submit w-100 mt-4">Submit Report</button>
    </form>
</div>

<script>
    document.getElementById('offence_type').addEventListener('change', function () {
        document.getElementById('criminal_section')?.style.setProperty('display', this.value === 'criminal' ? 'block' : 'none');
        document.getElementById('traffic_section')?.style.setProperty('display', this.value === 'traffic' ? 'block' : 'none');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
