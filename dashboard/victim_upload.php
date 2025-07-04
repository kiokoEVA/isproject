<?php
session_start();

// Check login
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['police', 'victim'])) {
    header("Location: login.php");
    exit;
}

// Handle success/error messages
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Offence - Kenya Police Abstract System</title>

    <!-- ✅ Corrected Bootstrap CSS CDN -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"  rel="stylesheet">
    
    <style>
        body {
    background-color: rgb(248, 249, 250);
}

.login-card {
    max-width: 700px;
    margin: 80px auto;
    padding: 2.5rem;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
}

    </style>
</head>
<body>

<div class="login-card bg-white">

    <h3 class="text-center mb-4">Report an Offence</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars(urldecode($success)) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars(urldecode($error)) ?></div>
    <?php endif; ?>

    <form action="submit_offence.php" method="POST" enctype="multipart/form-data">

        <!-- Offence Type -->
        <div class="mb-3">
            <label for="offence_type" class="form-label">Type of Offence</label>
            <select id="offence_type" name="offence_type" class="form-select" required>
                <option value="">-- Select Offence Type --</option>
                <option value="criminal">Criminal Offence</option>
                <option value="traffic">Traffic Offence</option>
            </select>
        </div>

        <!-- Date and Time -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="incident_date" class="form-label">Date of Incident</label>
                <input type="date" name="incident_date" id="incident_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="incident_time" class="form-label">Time of Incident</label>
                <input type="time" name="incident_time" id="incident_time" class="form-control" required>
            </div>
        </div>

        <!-- Location -->
        <div class="mb-3">
            <label for="location" class="form-label">Location of Incident</label>
            <input type="text" name="location" id="location" class="form-control" placeholder="e.g., Nairobi CBD, Mombasa Road" required>
        </div>

        <!-- Victim Info -->
        <div class="mb-3">
            <label for="victim_name" class="form-label">Victim Name</label>
            <input type="text" name="victim_name" id="victim_name" class="form-control" required>
        </div>

        <!-- Victim National ID -->
        <div class="mb-3">
            <label for="victim_national_id" class="form-label">Victim National ID Number</label>
            <input type="text" name="victim_national_id" id="victim_national_id" class="form-control" placeholder="e.g., 30201456" required>
        </div>

        <!-- Victim Date of Birth -->
        <div class="mb-3">
            <label for="victim_dob" class="form-label">Victim Date of Birth</label>
            <input type="date" name="victim_dob" id="victim_dob" class="form-control" required>
        </div>

        <!-- Suspect / Offender Info -->
        <div class="mb-3">
            <label for="offender_details" class="form-label">Suspect/Offender Details</label>
            <textarea name="offender_details" id="offender_details" rows="3" class="form-control" placeholder="Name, description, vehicle plate, etc." required></textarea>
        </div>

        <!-- Description of Incident -->
        <div class="mb-3">
            <label for="description" class="form-label">Description of Incident</label>
            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Describe what happened..." required></textarea>
        </div>

        <!-- Conditional Fields Based on Offence Type -->

        <!-- Criminal Offence Section -->
        <div id="criminal_section" style="display:none;">
            <h5 class="mb-3">Criminal Offence Details</h5>
            <div class="mb-3">
                <label for="crime_type" class="form-label">Type of Crime</label>
                <input type="text" name="crime_type" id="crime_type" class="form-control" placeholder="e.g., Theft, Assault, Robbery">
            </div>
            <div class="mb-3">
                <label for="witnesses" class="form-label">Witnesses (if any)</label>
                <textarea name="witnesses" id="witnesses" class="form-control" rows="2" placeholder="Names and contact info"></textarea>
            </div>
        </div>

        <!-- Traffic Offence Section -->
        <div id="traffic_section" style="display:none;">
            <h5 class="mb-3">Traffic Offence Details</h5>
            <div class="mb-3">
                <label for="vehicle_plate" class="form-label">Vehicle Plate Number</label>
                <input type="text" name="vehicle_plate" id="vehicle_plate" class="form-control" placeholder="e.g., KCF 123Z">
            </div>
            <div class="mb-3">
                <label for="violation_type" class="form-label">Type of Violation</label>
                <input type="text" name="violation_type" id="violation_type" class="form-control" placeholder="e.g., Over speeding, Reckless driving">
            </div>
        </div>

        <!-- Attachments -->
        <div class="mb-3">
            <label for="attachments" class="form-label">Upload Supporting Documents</label>
            <input type="file" name="attachments[]" id="attachments" multiple class="form-control">
            <small class="text-muted">You can upload multiple files (photos, reports, etc.)</small>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Submit Report</button>

    </form>
</div>

<!-- Show/hide sections dynamically -->
<script>
    document.getElementById('offence_type').addEventListener('change', function () {
        console.log("Dropdown changed:", this.value); // Debug log
        var criminalSection = document.getElementById('criminal_section');
        var trafficSection = document.getElementById('traffic_section');

        if (this.value === 'criminal') {
            criminalSection.style.display = 'block';
            trafficSection.style.display = 'none';
        } else if (this.value === 'traffic') {
            criminalSection.style.display = 'none';
            trafficSection.style.display = 'block';
        } else {
            criminalSection.style.display = 'none';
            trafficSection.style.display = 'none';
        }
    });
</script>

<!-- ✅ Corrected Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>