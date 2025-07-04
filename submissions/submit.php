<?php
session_start();
include '../includes/db.php'; // Adjust path if necessary

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'victim') {
    header("Location: ../../login.php");
    exit;
}

// Debug: Check if db.php is included correctly
if (!isset($conn)) {
    die("Database connection not established.");
}

$user_id = $_SESSION['user']['id'];

// Collect form data
$offence_type = $_POST['offence_type'];
$incident_date = $_POST['incident_date'];
$incident_time = $_POST['incident_time'];
$location = $conn->real_escape_string($_POST['location']);
$victim_name = $conn->real_escape_string($_POST['victim_name']);
$victim_national_id = $conn->real_escape_string($_POST['victim_national_id']);
$victim_dob = $_POST['victim_dob'];
$offender_details = $conn->real_escape_string($_POST['offender_details']);
$description = $conn->real_escape_string($_POST['description']);

$crime_type = isset($_POST['crime_type']) ? $conn->real_escape_string($_POST['crime_type']) : null;
$witnesses = isset($_POST['witnesses']) ? $conn->real_escape_string($_POST['witnesses']) : null;
$vehicle_plate = isset($_POST['vehicle_plate']) ? $conn->real_escape_string($_POST['vehicle_plate']) : null;
$violation_type = isset($_POST['violation_type']) ? $conn->real_escape_string($_POST['violation_type']) : null;

// Upload Files
$upload_dir = "../../uploads/";
$file_paths = [];

foreach ($_FILES['attachments']['name'] as $i => $name) {
    if ($_FILES['attachments']['error'][$i] === 0) {
        $tmp_name = $_FILES['attachments']['tmp_name'][$i];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $new_name = uniqid("doc_") . "." . $ext;
        move_uploaded_file($tmp_name, $upload_dir . $new_name);
        $file_paths[] = $new_name;
    }
}

$file_json = json_encode($file_paths);

// Insert into DB
$stmt = $conn->prepare("
    INSERT INTO abstract_reports (
        user_id, offence_type, incident_date, incident_time, location,
        victim_name, victim_national_id, victim_dob, offender_details, description,
        crime_type, witnesses, vehicle_plate, violation_type, file_paths
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issssssssssssss",
    $user_id, $offence_type, $incident_date, $incident_time, $location,
    $victim_name, $victim_national_id, $victim_dob, $offender_details, $description,
    $crime_type, $witnesses, $vehicle_plate, $violation_type, $file_json
);

if ($stmt->execute()) {
    $request_id = $conn->insert_id;

    // Get victim email
    $email_sql = "SELECT email FROM users WHERE id = ?";
    $email_stmt = $conn->prepare($email_sql);
    $email_stmt->bind_param("i", $user_id);
    $email_stmt->execute();
    $email_result = $email_stmt->get_result();
    $email_row = $email_result->fetch_assoc();
    $victim_email = $email_row['email'];

    // Email confirmation
    $subject = "Your Report Has Been Submitted (#$request_id)";
    $message = "
        Thank you for submitting your report.
        
        Your reference ID: $request_id
        Status: Pending Approval
        
        We will notify you once your report has been reviewed.
        
        You can check the status anytime at:
        http://yourdomain.com/dashboard/victim_dashboard.php
    ";
    $headers = "From: noreply@kenyapolice.gov";

    mail($victim_email, $subject, $message, $headers);

    header("Location: ../submissions/thank_you.php?id=$request_id");
    exit;
} else {
    echo "Error submitting report.";
}

$stmt->close();
$conn->close();
?>