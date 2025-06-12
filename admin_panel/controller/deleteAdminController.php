<?php
// filepath: c:\xampp\htdocs\NaiTsa\admin_panel\controller\deleteAdminController.php
include_once "../config/dbconnect.php";
$admin_id = $_POST['record'];
$query = "DELETE FROM admin WHERE Admin_ID='$admin_id'";
$data = mysqli_query($conn, $query);
if($data){
    echo "Admin deleted successfully!";
} else {
    echo "Unable to delete admin.";
}
?>