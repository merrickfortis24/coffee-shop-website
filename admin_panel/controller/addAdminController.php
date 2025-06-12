<?php
include_once "../config/dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_admin'])) {
    $name = trim($_POST['admin_name']);
    $email = trim($_POST['admin_email']);
    $role = $_POST['admin_role'];
    $status = $_POST['admin_status'];
    $password = $_POST['admin_password'];
    $errors = [];

    // Validate
    if (!$name) $errors[] = "Name is required.";
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (!$password || strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if (!$role) $errors[] = "Role is required.";
    if (!$status) $errors[] = "Status is required.";

    // Check email uniqueness
    $stmt = $conn->prepare("SELECT 1 FROM admin WHERE Admin_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $errors[] = "Email already exists.";
    $stmt->close();

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO admin (Admin_Name, Admin_password, Admin_email, Admin_role, Status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $hashed, $email, $role, $status);
        if ($stmt->execute()) {
            echo "Admin registered successfully!";
        } else {
            echo "Registration failed. Please try again.";
        }
        $stmt->close();
    } else {
        echo implode(" ", $errors);
    }
    exit;
} else {
    echo "Invalid request.";
    exit;
}