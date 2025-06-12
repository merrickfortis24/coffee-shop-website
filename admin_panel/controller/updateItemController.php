<?php
include_once "../config/dbconnect.php";

$product_id = $_POST['Product_ID'];
$p_name    = $_POST['Product_name'];
$p_desc    = $_POST['Product_desc'];
$p_price   = $_POST['Price'];
$category  = $_POST['Category_ID'];

if (isset($_FILES['newImage']) && $_FILES['newImage']['name'] != '') {
    $location = "./uploads/";
    $img = $_FILES['newImage']['name'];
    $tmp = $_FILES['newImage']['tmp_name'];
    $dir = '../uploads/';
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif','webp');
    $image = rand(1000,1000000) . "." . $ext;
    $final_image = $location . $image;
    if (in_array($ext, $valid_extensions)) {
        move_uploaded_file($tmp, $dir . $image);
    }
} else {
    $final_image = $_POST['existingImage'];
}

$updateItem = mysqli_query($conn,"UPDATE product SET 
    Product_name='$p_name', 
    Product_desc='$p_desc', 
    Price=$p_price,
    Category_ID=$category,
    product_image='$final_image' 
    WHERE Product_ID=$product_id");

if($updateItem) {
    echo "true";
}
?>