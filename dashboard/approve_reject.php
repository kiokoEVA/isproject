<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'police') {
    header("Location: ../login.php");
    exit;
}

include '../includes/db.php';

if (isset($_GET['id'], $_GET['action'])) {
    $report_id = intval($_GET['id']);
    $action = strtolower($_GET['action']);

    if (!in_array($action, ['approve', 'reject'])) {
        $_SESSION['error'] = "Invalid action.";
        header("Location:../officer.php");
        exit;
    }

    // Set approval status and message
    $status = ($action === 'approve') ? 'approved' : 'rejected';
    $message_content = ($action === 'approve')
        ? "Your abstract report has been approved."
        : "Your abstract report has been rejected. Please resubmit with corrections.";

    // Fetch report to get user_id (victim)
    $stmt = $conn->prepare("SELECT user_id FROM abstract_reports WHERE id = ?");
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Report not found.";
        header("Location:../officer.php");
        exit;
    }

    $report = $result->fetch_assoc();
    $user_id = $report['user_id'];

    // Update report status
    $update_stmt = $conn->prepare("UPDATE abstract_reports SET approval_status = ? WHERE id = ?");
    $update_stmt->bind_param("si", $status, $report_id);
    $update_stmt->execute();

    // Save message for the victim
    $insert_msg = $conn->prepare("INSERT INTO messages (user_id, message, created_at) VALUES (?, ?, NOW())");
    $insert_msg->bind_param("is", $user_id, $message_content);
    $insert_msg->execute();

    $_SESSION['success'] = "Report status updated successfully and victim notified.";
} else {
    $_SESSION['error'] = "Missing report ID or action.";
}

header("Location: ../officer.php");
exit;