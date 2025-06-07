<?php
$connection = mysqli_connect("localhost", "root", "", "coffee_shop");
if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $query = "SELECT * FROM admin WHERE Admin_email='$email' LIMIT 1";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
}
?>