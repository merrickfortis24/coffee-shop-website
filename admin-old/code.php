<?php
$connection = mysqli_connect("localhost", "root", "", "coffee_shop");
session_start();

if (isset($_POST['add_admin_btn'])) {
    $Admin_Name = $_POST['Admin_Name'];
    $Admin_email = $_POST['Admin_email'];
    $Admin_password = $_POST['Admin_password'];
    $confirm_password = $_POST['confirm_password'];
    $Admin_role = $_POST['Admin_role'];
    $Status = $_POST['Status'];
    $Created_at = date('Y-m-d H:i:s');
    $Updated_at = date('Y-m-d H:i:s');

    if ($Admin_password === $confirm_password) {
        $hashed_password = password_hash($Admin_password, PASSWORD_DEFAULT);

        $query = "INSERT INTO admin (Admin_Name, Admin_password, Admin_email, Admin_role, Status, Created_at, Updated_at) 
                  VALUES ('$Admin_Name', '$hashed_password', '$Admin_email', '$Admin_role', '$Status', '$Created_at', '$Updated_at')";
        if (mysqli_query($connection, $query)) {
            $_SESSION['status'] = "Admin added successfully!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Database error: " . mysqli_error($connection);
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "Passwords do not match!";
        $_SESSION['status_code'] = "error";
    }
    header("Location: register.php");
    exit();
}

if (isset($_POST['update_admin_btn'])) {
    $id = $_POST['edit_admin_id'];
    $name = $_POST['edit_Admin_Name'];
    $email = $_POST['edit_Admin_email'];
    $role = $_POST['edit_Admin_role'];
    $status = $_POST['edit_Status'];
    $Updated_at = date('Y-m-d H:i:s');

    $new_password = $_POST['edit_Admin_password'];
    $confirm_password = $_POST['edit_confirm_password'];

    if (!empty($new_password)) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $query = "UPDATE admin SET Admin_Name='$name', Admin_email='$email', Admin_role='$role', Status='$status', Admin_password='$hashed_password', Updated_at='$Updated_at' WHERE Admin_ID='$id'";
        } else {
            $_SESSION['status'] = "Passwords do not match!";
            $_SESSION['status_code'] = "error";
            header("Location: register.php");
            exit();
        }
    } else {
        $query = "UPDATE admin SET Admin_Name='$name', Admin_email='$email', Admin_role='$role', Status='$status', Updated_at='$Updated_at' WHERE Admin_ID='$id'";
    }

    if (mysqli_query($connection, $query)) {
        $_SESSION['status'] = "Admin updated successfully!";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Database error: " . mysqli_error($connection);
        $_SESSION['status_code'] = "error";
    }
    header("Location: register.php");
    exit();
}

if (isset($_POST['delete_admin_btn'])) {
    $id = $_POST['delete_admin_btn'];
    $query = "DELETE FROM admin WHERE Admin_ID='$id'";
    if (mysqli_query($connection, $query)) {
        $_SESSION['status'] = "Admin deleted successfully!";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Database error: " . mysqli_error($connection);
        $_SESSION['status_code'] = "error";
    }
    header("Location: register.php");
    exit();
}
?>