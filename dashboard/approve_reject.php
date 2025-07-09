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
        $_SESSION['error'] = "Invalid action specified.";
        header("Location: officer.php");
        exit;
    }

    // Set status and message content
    $status = ($action === 'approve') ? 'approved' : 'rejected';
    $message_content = ($status === 'approved') 
        ? "✅ Your abstract report has been approved by the police." 
        : "❌ Your abstract report has been rejected. Please review and resubmit.";

    // Fetch report to get correct user_id
    $stmt = $conn->prepare("SELECT id, user_id FROM abstract_reports WHERE id = ?");
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Report not found or already processed.";
        header("Location: officer.php");
        exit;
    }

    $report = $result->fetch_assoc();
    $victim_id = $report['user_id'];

    // Update report approval status
    $update_stmt = $conn->prepare("UPDATE abstract_reports SET approval_status = ? WHERE id = ?");
    $update_stmt->bind_param("si", $status, $report_id);
    $update_stmt->execute();

    // Notify victim with a message
    $insert_msg = $conn->prepare("INSERT INTO messages (user_id, message, created_at) VALUES (?, ?, NOW())");
    $insert_msg->bind_param("is", $victim_id, $message_content);
    $insert_msg->execute();

    $_SESSION['success'] = "Report successfully {$status} and victim notified.";
} else {
    $_SESSION['error'] = "Missing or invalid report ID/action.";
}

header("Location: officer.php");
exit;
