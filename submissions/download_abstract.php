<?php
session_start();

// Check if user is logged in and is a victim
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'victim') {
    die("Unauthorized access.");
}

include '../includes/db.php';

$user_id = $_SESSION['user']['id'];

// Get report ID from URL
if (!isset($_GET['report_id'])) {
    die("Invalid request. Report ID missing.");
}
$report_id = intval($_GET['report_id']);

// Fetch report details from database
$sql = "SELECT * FROM abstract_reports WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $report_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Report not found or you don't have permission to access it.");
}

$report = $result->fetch_assoc();

// Check if abstract is approved
if (strtolower($report['approval_status']) !== 'approved') {
    die("Abstract has not been approved yet.");
}

// Check if file exists
$file_path = "../uploads/abstracts/" . $report['abstract_file'];
if (!file_exists($file_path)) {
    die("File not found.");
}

// Serve the file for download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
header('Content-Length: ' . filesize($file_path));
readfile($file_path);
exit;