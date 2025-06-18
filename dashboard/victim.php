<?php
session_start();
include '../includes/auth.php'; // contains isLoggedIn(), redirectUser(), etc.
include '../layouts/header.php';

// Only allow victims here
if (!isVictim()) {
    header("Location: ../login.php");
    exit;
}
?>

<div class="container mt-5">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?></h2>
    <p>This is your dashboard as a Victim.</p>

    <div class="mb-4">
        <a href="submit_request.php" class="btn btn-primary">Submit New Abstract Request</a>
    </div>

    <h4>Your Abstract Requests</h4>
    <!-- Fetch and display abstracts from DB -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            <!-- Sample row -->
            <tr>
                <td>AB001</td>
                <td>Approved</td>
                <td><a href="../generate_pdf.php?id=1" class="btn btn-sm btn-success">PDF</a></td>
            </tr>
        </tbody>
    </table>
</div>

<?php include '../layouts/footer.php'; ?>