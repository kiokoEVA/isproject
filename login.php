<?php
session_start();

// Initialize error message
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db.php'; // Database connection

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $selected_role = $_POST['role']; // Selected role from dropdown

    // Query to fetch user by email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {

            // Check if selected role matches user's role
            if ($user['role'] === $selected_role) {
                // Set session and redirect
                $_SESSION['user'] = $user;

                // Redirect based on role
                switch ($user['role']) {
                    case 'victim':
                        header("Location: victim/dashboard.php");
                        break;
                    case 'police':
                        header("Location: police/view_requests.php");
                        break;
                    case 'lawyer':
                        header("Location: lawyer/view_abstracts.php");
                        break;
                    case 'admin': // Assuming admin handles insurance validation
                        header("Location: admin/manage_insurance.php");
                        break;
                    default:
                        $error = "Unknown user role.";
                }
                exit;
            } else {
                $error = "Your selected role does not match your account.";
            }
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Kenya Police Abstract System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"  rel="stylesheet">
    <style>
        body {
            background-color:rgb(248, 249, 250);
        }
        .login-card {
            max-width: 500px;
            margin: 80px auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>
<div class="login-card bg-blue-light">
    <h3 class="text-center mb-4">Login to Kenya Police Abstract System</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Login As</label>
            <select name="role" id="role" class="form-select" required>
                <option value="">-- Select Role --</option>
                <option value="victim">Victim</option>
                <option value="police">Police Officer</option>
                <option value="lawyer">Lawyer</option>
                <option value="admin">Insurance </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <p class="mt-3 text-center small">
        Don't have an account? <a href="register.php">Register here</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>