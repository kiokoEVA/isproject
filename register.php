<?php    
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db.php';

    $id = $conn->real_escape_string($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    if (empty($id) || empty($name) || empty($email) || empty($password) || empty($role) || empty($phone) || empty($address)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match('/^(?:\+254|0)(7\d{8}|1\d{8})$/', $phone)) {
        $error = "Invalid phone number. Must start with +254 or 07 / 01 and be 10–13 digits.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_stmt = $conn->prepare("
                INSERT INTO users (id, name, email, password, role, phone, address)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $insert_stmt->bind_param("sssssss", $id, $name, $email, $hashed_password, $role, $phone, $address);

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

<?php include 'header.php'; ?>

<style>
    body {
        background: linear-gradient(135deg, #000000, #ff0000, #ffffff, #008000);
        background-size: 600% 600%;
        animation: gradientShift 15s ease infinite;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .register-card {
        max-width: 500px;
        margin: 80px auto;
        padding: 2rem;
        border-radius: 1rem;
        background-color: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .kenya-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .kenya-header h3 {
        font-weight: bold;
        color: #000;
    }

    .btn-kenya {
        background-color: #008000 !important;
        color: white !important;
        font-weight: bold;
    }

    .btn-kenya:hover {
        background-color: #006400 !important;
    }

    .flag-icon {
        width: 30px;
        vertical-align: middle;
        margin-right: 10px;
    }

    .form-label {
        font-weight: 500;
    }

    .text-muted a {
        color: #000000;
        text-decoration: underline;
    }
</style>

<body>
    <div class="register-card">
        <div class="kenya-header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Flag_of_Kenya.svg/1200px-Flag_of_Kenya.svg.png" class="flag-icon" alt="Kenya Flag">
            <h3>Register - Kenya Police Abstract Issuance System</h3>
        </div>

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

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" name="phone" id="phone" class="form-control" required
                       pattern="^(\+254|0)(7\d{8}|1\d{8})$"
                       title="Phone must start with +254 or 07 / 01 and be 10 digits long">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-kenya w-100">Register</button>
        </form>

        <p class="mt-3 text-center small text-muted">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>
