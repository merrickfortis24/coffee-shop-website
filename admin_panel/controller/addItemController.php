<?php
    include_once "../config/dbconnect.php";
    
    if(isset($_POST['upload']))
    {
        $ProductName = $_POST['p_name'];
        $desc = $_POST['p_desc'];
        $price = $_POST['p_price'];
        $category = $_POST['category'];
        
        $name = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
    
        $location = "./uploads/";
        $image = $location . $name;

        $target_dir = "../uploads/";
        $finalImage = $target_dir . $name;

        move_uploaded_file($temp, $finalImage);

        // Insert product directly with Price
        $insert = mysqli_query($conn, "INSERT INTO product
            (Product_name, product_image, Product_desc, Price, Category_ID) 
            VALUES ('$ProductName', '$image', '$desc', '$price', '$category')");

        if(!$insert)
        {
            echo mysqli_error($conn);
        }
        else
        {
            echo "Records added successfully.";
        }
    }
?>