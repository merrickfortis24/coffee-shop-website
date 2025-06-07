<?php
<?php
include('includes/db_connect.php');

$admin_id = $_POST['Admin_ID'];
$name = $_POST['Admin_Name'];
$email = $_POST['Admin_email'];

$query = "UPDATE admin SET Admin_Name='$name', Admin_email='$email' WHERE Admin_ID=$admin_id";
if (mysqli_query($conn, $query)) {
    header("Location: admin_profile.php?success=1");
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>