<?php 
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db.php';

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $selected_role = $_POST['role'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            if ($user['role'] === $selected_role) {
                $_SESSION['user'] = $user;

                switch ($user['role']) {
                    case 'victim':
                        header("Location: dashboard/victim.home.php");
                        break;
                    case 'police':
                        header("Location: dashboard/officer.php");
                        break;
                    case 'lawyer':
                        header("Location: dashboard/lawyer.php");
                        break;
                    case 'insurance':
                        header("Location: dashboard/insurance.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #006400, #ffffff, #b41c1c); /* green, white, red */
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            max-width: 500px;
            width: 100%;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            padding: 40px;
            animation: fadeIn 0.8s ease-in-out;
        }

        .login-card h3 {
            font-weight: bold;
            color: #000;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 100, 0, 0.25);
            border-color: #006400;
        }

        .text-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .text-link a {
            color: #b41c1c;
            text-decoration: none;
        }

        .text-link a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="login-card">
    <h3><i class="fas fa-lock me-2"></i>Login to Abstract Issuance System</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control form-control-lg" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control form-control-lg" required>
        </div>

        <div class="mb-4">
            <label for="role" class="form-label">Login As</label>
            <select name="role" id="role" class="form-select form-select-lg" required>
                <option value="">-- Select Role --</option>
                <option value="victim">Victim</option>
                <option value="police">Police Officer</option>
                <option value="lawyer">Lawyer</option>
                <option value="insurance">Insurance Representative</option>
            </select>
        </div>

        <!-- ✅ GREEN BUTTON USING btn-success -->
        <button type="submit" class="btn btn-success btn-lg w-100">Login</button>
    </form>

    <div class="text-link">
        Don't have an account? <a href="register.php">Register here</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
