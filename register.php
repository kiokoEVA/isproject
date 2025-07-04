<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db.php'; // Your database connection file

    $id = $conn->real_escape_string($_POST['id']); // New line
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate input
    if (empty($id) || empty($name) || empty($email) || empty($password) || empty($role)) { // Updated line
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $insert_stmt = $conn->prepare("
                INSERT INTO users (id, name, email, password, role) VALUES (?, ?, ?, ?, ?)
            ");
            $insert_stmt->bind_param("sssss", $id, $name, $email, $hashed_password, $role); // Updated line

            if ($insert_stmt->execute()) {
                $_SESSION['success'] = "Registration successful! Please log in.";
                header("Location: login.php");
                exit;
            } else {
                $error = "Registration failed. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Kenya Police Abstract System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
        }
        .register-card {
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
<div class="register-card bg-white">
    <h3 class="text-center mb-4">Register - Kenya Police Abstract System</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form method="post" action="register.php">
        <div class="mb-3">
            <label for="id" class="form-label">User ID</label>
            <input type="text" name="id" id="id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required minlength="6">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Register As</label>
            <select name="role" id="role" class="form-select" required>
                <option value="">-- Select Role --</option>
                <option value="victim">Victim</option>
                <option value="police">Police Officer</option>
                <option value="lawyer">Lawyer</option>
                <option value="insurance">Insurance</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100">Register</button>
    </form>

    <p class="mt-3 text-center small">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>