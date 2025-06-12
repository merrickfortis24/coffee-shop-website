<?php
// filepath: c:\xampp\htdocs\NaiTsa\admin_panel\controller\updateAdminController.php
include_once "../config/dbconnect.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_admin'])) {
    $id = $_POST['admin_id'];
    $name = trim($_POST['admin_name']);
    $email = trim($_POST['admin_email']);
    $role = $_POST['admin_role'];
    $status = $_POST['admin_status'];

    $stmt = $conn->prepare("UPDATE admin SET Admin_Name=?, Admin_email=?, Admin_role=?, Status=? WHERE Admin_ID=?");
    $stmt->bind_param("ssssi", $name, $email, $role, $status, $id);
    if ($stmt->execute()) {
        echo "Admin updated successfully!";
    } else {
        echo "Update failed. Please try again.";
    }
    $stmt->close();
}
?>