<?php
require_once './config/dbconnect.php';
session_start();

if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['admin_email']);
    $password = trim($_POST['admin_password']);

    $sql = "SELECT Admin_ID, Admin_email, Admin_password FROM admin WHERE Admin_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['Admin_password'])) {
        $_SESSION['admin_id'] = $admin['Admin_ID'];
        header('Location: index.php');
        exit();
    } else {
        $error = 'Authentication failed. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/login.css"/>
    <style>
        body {
            background: #3B3131;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: #fff;
            padding: 2.5rem 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
        }
        .login-title {
            color: #3B3131;
            margin-bottom: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Admin Login</h2>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php } ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="admin_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="admin_email" name="admin_email" required>
            </div>
            <div class="mb-3">
                <label for="admin_password" class="form-label">Password</label>
                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
    <!-- Bootstrap 5 JS Bundle CDN (optional, for components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>